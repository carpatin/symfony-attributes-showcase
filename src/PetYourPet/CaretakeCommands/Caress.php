<?php

declare(strict_types=1);

namespace App\PetYourPet\CaretakeCommands;

use App\Dto\PetYourPet\PetCaretake\CaressDetails;

class Caress {
    public function execute(string $petName, CaressDetails $details): void
    {
        dd(__CLASS__, $petName, $details);
    }
}
