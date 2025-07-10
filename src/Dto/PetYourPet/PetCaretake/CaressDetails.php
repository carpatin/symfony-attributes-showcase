<?php

declare(strict_types=1);

namespace App\Dto\PetYourPet\PetCaretake;

use Symfony\Component\Validator\Constraints as Assert;

class CaressDetails
{
    public function __construct(
        #[Assert\GreaterThanOrEqual(0)]
        #[Assert\LessThanOrEqual(60)]
        public int $caressTimeMinutes,
    ) {
        //
    }
}
