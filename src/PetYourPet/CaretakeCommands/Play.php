<?php

declare(strict_types=1);

namespace App\PetYourPet\CaretakeCommands;

use App\Dto\PetYourPet\PetCaretake\PlayDetails;

class Play
{
    public function execute(string $petName, PlayDetails $details): void
    {
        dd(__CLASS__, $petName, $details);
    }
}
