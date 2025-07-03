<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\MapEntityByPayloadField;
use App\Dto\PetYourPet\PetCaretake;
use App\Entity\Pet;
use App\Repository\PetRepository;
use App\Service\PetYourPet\CaretakeCommands\Caress;
use App\Service\PetYourPet\CaretakeCommands\GiveFood;
use App\Service\PetYourPet\CaretakeCommands\GiveWater;
use App\Service\PetYourPet\CaretakeCommands\Play;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pets')]
class PetYourPetController extends AbstractController
{
    // Example of using the Symfony\Bridge\Twig\Attribute\Template attribute introduced in Symfony 6.2 as a native
    // alternative to the #[Template] attribute from SensioFrameworkExtraBundle.
    // It is part of the symfony/twig-bridge, so you need it installed to use this.

    #[Route('/', name: 'app_petyourpet_list', methods: ['GET'])]
    #[Template(template: 'pet_your_pet/list.html.twig')]
    public function listPets(
        PetRepository $petRepo,
        // Example usages of the #[MapQueryParameter], which was introduced in 6.3 for mapping query parameter
        // values to constructor arguments:
        #[MapQueryParameter(filter: FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^[\p{L}\p{Zs}]+$/'])] ?string $search = null,
        #[MapQueryParameter(filter: FILTER_VALIDATE_INT)] int $pageSize = 5,
        #[MapQueryParameter(filter: FILTER_VALIDATE_INT)] int $page = 1,
    ): array {
        // Example usage of Pagerfanta for paginating query builders easily
        $paginatedPets = $petRepo->findByName($search);
        $paginatedPets->setMaxPerPage($pageSize);
        $paginatedPets->setCurrentPage($page);

        return ['pets' => $paginatedPets];
    }

    // The Mapped Route Parameters exist since 7.1.
    // They load entities by route param values, just by mapping the name of the route param to the name of the
    // controller parameter. It functions by doing findOneBy(['name'=> $name]) in the background.
    // It also works loading multiple entities: ex. /owner/{id:owner}/pet/{name:pet}.
    #[Route('/{name:pet}', name: 'app_petyourpet_status', methods: ['GET'])]
    public function petStatus(
        // Before 7.1 you would need to use the #[MapEntity] attribute from the SensioFrameworkExtraBundle.
        // Example: #[MapEntity(mapping: ['name' => 'name'])] Pet $pet
        Pet $pet,
    ): Response {
        return $this->render('pet_your_pet/status.html.twig', ['pet' => $pet]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    #[Route('/pet', name: 'app_petyourpet_pet', methods: ['POST'])]
    public function pet(
        // Example of using #[MapRequestPayload], introduced in Symfony 6.3
        // It also supports mapping to nested objects, as long as the form/json fields nesting matches the one in
        // the DTOs.
        #[MapRequestPayload] PetCaretake $caretake,
        // Example using #[AutowireLocator], introduced in Symfony 6.4
        // It works perfectly for implementing the command pattern.
        #[AutowireLocator([
            PetCaretake::COMMAND_GIVE_WATER => GiveWater::class,
            PetCaretake::COMMAND_GIVE_FOOD  => GiveFood::class,
            PetCaretake::COMMAND_CARESS     => Caress::class,
            PetCaretake::COMMAND_PLAY       => Play::class,
        ])]
        ContainerInterface $caretakeCommands,
        // Below an example of using a custom attribute to map a custom field in the POST body to an entity.
        #[MapEntityByPayloadField(field: 'name')]
        Pet $pet,
        EntityManagerInterface $entityManager,
    ): Response {
        $command = $caretakeCommands->get($caretake->command);

        $command->execute($pet, $caretake->getCommandDetails());

        $entityManager->flush();

        return $this->redirectToRoute('app_petyourpet_status', ['name' => $pet->getName()]);
    }
}
