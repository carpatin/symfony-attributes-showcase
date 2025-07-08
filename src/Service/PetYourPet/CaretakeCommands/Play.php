<?php

declare(strict_types=1);

namespace App\Service\PetYourPet\CaretakeCommands;

use App\Dto\PetYourPet\PetCaretake\PlayDetails;
use App\Entity\PetYourPet\Pet;
use App\Service\PetYourPet\PetMood;
use App\Service\PetYourPet\PetYourPetLoggerAwareTrait;

class Play
{
    use PetYourPetLoggerAwareTrait;

    public function execute(Pet $pet, PlayDetails $details): void
    {
        $this->logger->info(
            'Playing with pet',
            [
                'pet_name' => $pet->getName(),
                'minutes'  => $details->playTimeMinutes,
            ],
        );

        $threshold = random_int(1, 10);
        if ($details->playTimeMinutes > $threshold) {
            $pet->setMood(PetMood::RELAXED);
            $pet->setIsHungry(true);
            $this->logger->info('Pet is relaxed, playing helped!', ['pet_name' => $pet->getName()]);

            return;
        }

        if ($details->playTimeMinutes > $threshold / 2) {
            $pet->setMood(PetMood::HYPER);
            $this->logger->info('Pet is hyper, playing stopped too early!', ['pet_name' => $pet->getName()]);

            return;
        }

        $this->logger->info('Pet needs more playing!', ['pet_name' => $pet->getName()]);
    }
}
