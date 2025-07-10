<?php

declare(strict_types=1);

namespace App\Dto\PetYourPet\PetCaretake;

use Symfony\Component\Validator\Constraints as Assert;

class GiveWaterDetails
{
    public function __construct(
        #[Assert\GreaterThanOrEqual(0)]
        #[Assert\LessThan(10)]
        public int $bowlsCount,
        public bool $isCooledWater = false,
    ) {
        //
    }
}
