<?php

namespace App\Tests\Functional\Controller;

use App\Entity\PhotoAlbum\Photo;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoAlbumControllerTest extends WebTestCase
{
    private array $testFiles = [];

    protected function setUp(): void
    {
        parent::setUp();

        for ($i = 1; $i <= 3; $i++) {
            $filePath = sys_get_temp_dir().'/test_photo_'.$i.'.jpg';
            copy(__DIR__.'/../../Fixtures/test_image.jpg', $filePath);
            $this->testFiles[] = $filePath;
        }
    }

    public function testMultiplePhotoUpload(): void
    {
        $client = static::createClient();

        // logging in the user that can upload photos
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('uploader@example.com');
        $client->loginUser($testUser);

        // get the index page where the form resides to obtain the CSRF token
        $client->followRedirects();
        $crawler = $client->request('GET', '/photo-album');
        $csrfToken = $crawler->filter('input[name="_csrf"]')->attr('value');

        // perform the POST request to the controller action that we are actually testing
        $client->followRedirects(false);
        $client->request(
            'POST',
            '/photo-album/multiple-upload',
            [
                '_csrf'       => $csrfToken,
                'title'       => 'Test',
                'description' => 'Description',
            ],
            [
                'photos' => [
                    new UploadedFile(
                        $this->testFiles[0],
                        'photo.jpg',
                        'image/jpeg',
                        null,
                        true,
                    ),
                    new UploadedFile(
                        $this->testFiles[1],
                        'photo.jpg',
                        'image/jpeg',
                        null,
                        true,
                    ),
                    new UploadedFile(
                        $this->testFiles[2],
                        'photo.jpg',
                        'image/jpeg',
                        null,
                        true,
                    ),
                ],
            ],
        );
        // we are expecting a redirect after a successful upload
        $response = $client->getResponse();
        $this->assertTrue($response->isRedirect());
        $redirectUrl = $response->headers->get('Location');
        $client->request('GET', $redirectUrl);

        // we assert that the index page load is successful and there are success flash messages displayed as effect
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('.text-green-800', 'uploaded successfully!');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // clean up temp directory
        foreach ($this->testFiles as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // clean up the database after running the tests
        $repository = self::getContainer()->get('doctrine')->getRepository(Photo::class);
        $em = self::getContainer()->get('doctrine')->getManager();
        $entities = $repository->findAll();
        foreach ($entities as $entity) {
            $em->remove($entity);
        }

        $em->flush();
    }
}
