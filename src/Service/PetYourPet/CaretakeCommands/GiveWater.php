<?php

declare(strict_types=1);

namespace App\Service\PetYourPet\CaretakeCommands;

use App\Dto\PetYourPet\PetCaretake\GiveWaterDetails;
use App\Entity\Pet;
use App\Service\PetYourPet\PetMood;
use App\Service\PetYourPet\PetYourPetLoggerAwareTrait;

class GiveWater
{
    use PetYourPetLoggerAwareTrait;

    public function execute(Pet $pet, GiveWaterDetails $details): void
    {
        $this->logger->info(
            'Giving water to pet',
            [
                'pet_name'        => $pet->getName(),
                'is_cooled_water' => $details->isCooledWater,
                'servings'        => $details->bowlsCount,
            ],
        );

        if ($details->bowlsCount > 3 || !$pet->isThirsty()) {
            $pet->setMood(PetMood::APATHETIC);
            $this->logger->info('Pet is apathetic because of too much water', ['pet_name' => $pet->getName()]);

            return;
        }

        if ($details->bowlsCount > 0) {
            $pet->setIsThirsty(false);
            $this->logger->info('Pet is no longer thirsty', ['pet_name' => $pet->getName()]);

            if ($details->isCooledWater) {
                $pet->setMood(PetMood::HYPER);
                $this->logger->info('Pet is hyper, cool water does that!', ['pet_name' => $pet->getName()]);
            } else {
                $pet->setMood(PetMood::RELAXED);
                $this->logger->info('Pet is relax, had a good drink!', ['pet_name' => $pet->getName()]);
            }

            return;
        }

        $this->logger->info('Pet needs water!', ['pet_name' => $pet->getName()]);
    }
}
