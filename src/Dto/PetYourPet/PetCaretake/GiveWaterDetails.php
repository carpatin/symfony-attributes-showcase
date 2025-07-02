<?php

declare(strict_types=1);

namespace App\Dto\PetYourPet\PetCaretake;

class GiveWaterDetails
{
    public function __construct(
        public int $bowlsCount,
        public bool $isCooledWater = false,
    ) {
        //
    }
}
