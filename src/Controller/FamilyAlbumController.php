<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\PhotoAlbum\Photo;
use App\Entity\User;
use App\Form\PhotoUploadForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapUploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Constraints as Assert;

#[Route('/family-album')]
final class FamilyAlbumController extends AbstractController
{
    #[Route('/', name: 'app_familyalbum_index')]
    public function index(): Response
    {
        $form = $this->createForm(PhotoUploadForm::class, options: [
            'action' => $this->generateUrl('app_familyalbum_upload'),
            'method' => 'POST',
        ]);

        return $this->render('family_album/index.html.twig', [
            'uploadForm' => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_UPLOADER')]
    #[Route('/upload', name: 'app_familyalbum_upload', methods: ['POST'])]
    public function upload(
        Request $request,
        EntityManagerInterface $em,
        #[CurrentUser]
        User $user,
    ) {
        $photo = new Photo();
        $form = $this->createForm(PhotoUploadForm::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $form->get('content')->getData() instanceof UploadedFile) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('content')->getData();
            $photo->setContent($uploadedFile->getContent());
            $photo->setFilename($uploadedFile->getClientOriginalName());
            $photo->setUploader($user);

            $em->persist($photo);
            $em->flush();
            $this->addFlash('success', 'Photo uploaded successfully!');
        } else {
            $this->addFlash('error', 'Photo upload failed!');
        }

        return $this->redirectToRoute('app_familyalbum_index');
    }
    // TODO: example with
    //#[MapUploadedFile([
    //new Assert\File(mimeTypes: ['image/png', 'image/jpeg']),
    //new Assert\Image(maxWidth: 1920, maxHeight: 1080),
    //])]
    //UploadedFile $file,
}
