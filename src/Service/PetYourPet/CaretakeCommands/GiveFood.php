<?php

declare(strict_types=1);

namespace App\Service\PetYourPet\CaretakeCommands;

use App\Dto\PetYourPet\PetCaretake\GiveFoodDetails;
use App\Entity\Pet;
use App\Service\PetYourPet\PetMood;
use App\Service\PetYourPet\PetYourPetLoggerAwareTrait;

class GiveFood
{
    use PetYourPetLoggerAwareTrait;

    public function execute(Pet $pet, GiveFoodDetails $details): void
    {
        $this->logger->info(
            'Feeding pet',
            [
                'pet_name'        => $pet->getName(),
                'is_premium_food' => $details->isPremiumFood,
                'servings'        => $details->foodServingsCount,
            ],
        );

        if ($details->foodServingsCount > 3 || !$pet->isHungry()) {
            $pet->setMood(PetMood::APATHETIC);
            $this->logger->info('Pet is apathetic because of too much food.', ['pet_name' => $pet->getName()]);

            return;
        }

        if ($details->foodServingsCount > 0) {
            $pet->setIsHungry(false);
            $this->logger->info('Pet is no longer hungry.', ['pet_name' => $pet->getName()]);

            if ($details->isPremiumFood) {
                $pet->setMood(PetMood::HYPER);
                $this->logger->info('Pet is hyper, good food!', ['pet_name' => $pet->getName()]);
            }

            return;
        }

        $this->logger->info('Pet needs food!', ['pet_name' => $pet->getName()]);
    }
}
