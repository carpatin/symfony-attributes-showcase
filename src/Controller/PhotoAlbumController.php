<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PhotoAlbum\BulkPhotosDetails;
use App\Entity\PhotoAlbum\Photo;
use App\Entity\User;
use App\Form\PhotoUploadForm;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Attribute\MapUploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/photo-album')]
final class PhotoAlbumController extends AbstractController
{
    #[Route('/', name: 'app_photoalbum_index')]
    public function index(
        PhotoRepository $photoRepository,
    ): Response {
        $form = $this->createForm(PhotoUploadForm::class, options: [
            'action' => $this->generateUrl('app_photoalbum_upload'),
            'method' => 'POST',
        ]);

        $photos = $photoRepository->findAll();

        return $this->render('photo_album/index.html.twig', [
            'uploadForm' => $form->createView(),
            'photos'     => $photos,
        ]);
    }

    #[IsGranted('ROLE_UPLOADER')]
    #[Route('/upload', name: 'app_photoalbum_upload', methods: ['POST'])]
    public function upload(
        #[CurrentUser]
        User $user,
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator,
    ) {
        $photo = new Photo();
        $form = $this->createForm(PhotoUploadForm::class, $photo);
        $form->handleRequest($request);

        try {
            if (!$form->isSubmitted()) {
                throw new RuntimeException('Form was not submitted');
            }

            // the following validates also CSRF
            if (!$form->isValid()) {
                throw new RuntimeException('Form validation failed');
            }

            $uploadedFile = $form->get('content')->getData();
            if (!$uploadedFile instanceof UploadedFile) {
                throw new RuntimeException('No file was uploaded');
            }

            $photo->setContent($uploadedFile->getContent());
            $photo->setFilename($uploadedFile->getClientOriginalName());
            $photo->setUploader($user);

            $errors = $validator->validate($photo);
            if (count($errors) > 0) {
                throw new ValidationFailedException($photo, $errors);
            }

            $em->persist($photo);
            $em->flush();

            $this->addFlash('success', sprintf('Photo %s uploaded successfully!', $photo->getTitle()));
        } catch (Exception $e) {
            $this->addFlash('error', sprintf('Photo upload failed: %s', $e->getMessage()));
        }

        return $this->redirectToRoute('app_photoalbum_index');
    }

    /**
     * @param $photos UploadedFile[]|array
     */
    #[IsGranted('ROLE_UPLOADER')]
    #[IsCsrfTokenValid(id: 'multiple_upload', tokenKey: '_csrf')]
    #[Route('/multiple-upload', name: 'app_photoalbum_multiple_upload', methods: ['POST'])]
    public function multipleUpload(
        #[MapRequestPayload]
        BulkPhotosDetails $bulkPhotosDetails,
        #[MapUploadedFile(
            constraints: [
                new Constraints\File(maxSize: '15M', mimeTypes: ['image/png', 'image/jpeg']),
                new Constraints\Image(maxWidth: 1920, maxHeight: 1080),
            ],
            name: 'photos',
            validationFailedStatusCode: 400
        )]
        array $photos,
        #[CurrentUser]
        User $user,
        EntityManagerInterface $em,
        ValidatorInterface $validator,
    ): Response {
        try {
            $c = 0;
            foreach ($photos as $uploadedPhoto) {
                $photo = new Photo();
                $photo->setContent($uploadedPhoto->getContent());
                $photo->setFilename($uploadedPhoto->getClientOriginalName());
                $photo->setUploader($user);
                $photo->setTitle($bulkPhotosDetails->title.' '.++$c);
                $photo->setDescription($bulkPhotosDetails->description);

                $errors = $validator->validate($photo);
                if (count($errors) > 0) {
                    throw new ValidationFailedException($photo, $errors);
                }

                $em->persist($photo);

                $this->addFlash('success', sprintf('Photo %s uploaded successfully!', $photo->getTitle()));
            }

            $em->flush();
        } catch (Exception $e) {
            $this->addFlash('error', sprintf('Photo upload failed: %s', $e->getMessage()));
        }

        return $this->redirectToRoute('app_photoalbum_index');
    }
}
