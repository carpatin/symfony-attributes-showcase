<?php

declare(strict_types=1);

namespace App\Dto\PetYourPet\PetCaretake;

class PlayDetails {
    public function __construct(
        public int $playTimeMinutes,
    ) {
        //
    }
}
