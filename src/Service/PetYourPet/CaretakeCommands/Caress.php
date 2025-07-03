<?php

declare(strict_types=1);

namespace App\Service\PetYourPet\CaretakeCommands;

use App\Dto\PetYourPet\PetCaretake\CaressDetails;
use App\Entity\Pet;
use App\Service\PetYourPet\PetMood;
use App\Service\PetYourPet\PetYourPetLoggerAwareTrait;
use Random\RandomException;

class Caress
{
    use PetYourPetLoggerAwareTrait;

    /**
     * @throws RandomException
     */
    public function execute(Pet $pet, CaressDetails $details): void
    {
        $this->logger->info('Caressing pet', ['pet_name' => $pet->getName(), 'minutes' => $details->caressTimeMinutes]);

        $threshold = random_int(1, 5);
        if ($details->caressTimeMinutes > $threshold) {
            $pet->setMood(PetMood::RELAXED);
            $pet->setIsThirsty(true);
            $this->logger->info('Pet is relaxed', ['pet_name' => $pet->getName()]);

            return;
        }

        $this->logger->info('Pet needs more caressing?', ['pet_name' => $pet->getName()]);
    }
}
