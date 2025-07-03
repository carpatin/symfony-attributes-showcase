<?php

declare(strict_types=1);

namespace App\Service\PetYourPet;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Adds to a service setter injection with the pet_your_pet channel logger.
 */
trait PetYourPetLoggerAwareTrait
{
    private LoggerInterface $logger;

    // Using the #[Required] attribute here instructs Symfony to do setter injection.
    // This attribute indicates that a property holds a required dependency.
    #[Required]
    public function setLogger(
        // The #[Autowire] attribute has clever argument handling. Although it has several arguments, you are usually
        // going to pass only one value and let it guess what you wanted (see below passing the service identifier).
        // It is available in Symfony starting with 6.1.
        // It can be used in both constructor and setter injection on arguments.
        //
        // Another way to get the same as below would be:
        // #[Autowire(service: 'monolog.logger.pet_your_pet')]
        //
        // Other options are:
        // - Injecting a parameter: #[Autowire('%kernel.project_dir%')]
        // - Injecting an expression: #[Autowire(expression: 'service("App\\Service\\TokenGenerator").generate()')]
        //
        #[Autowire('@monolog.logger.pet_your_pet')]
        LoggerInterface $logger,
    ): void {
        $this->logger = $logger;
    }
}
