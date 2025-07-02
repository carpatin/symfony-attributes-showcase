<?php

declare(strict_types=1);

namespace App\Dto\PetYourPet\PetCaretake;

class GiveFoodDetails
{
    public function __construct(
        public int $foodServingsCount,
        public bool $isPremiumFood = false,
    ) {
        //
    }
}
