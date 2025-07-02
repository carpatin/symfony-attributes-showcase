<?php

declare(strict_types=1);

namespace App\Dto\PetYourPet\PetCaretake;

class CaressDetails
{
    public function __construct(
        public int $caressTimeMinutes,
    ) {
        //
    }
}
