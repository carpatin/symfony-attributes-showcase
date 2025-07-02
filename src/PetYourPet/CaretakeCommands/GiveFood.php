<?php

declare(strict_types=1);

namespace App\PetYourPet\CaretakeCommands;

use App\Dto\PetYourPet\PetCaretake\GiveFoodDetails;

class GiveFood
{
    public function execute(string $petName, GiveFoodDetails $details): void
    {
        dd(__CLASS__, $petName, $details);
    }
}
