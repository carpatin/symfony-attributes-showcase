<?php

declare(strict_types=1);

namespace App\PetYourPet\CaretakeCommands;

use App\Dto\PetYourPet\PetCaretake\GiveWaterDetails;

class GiveWater
{
    public function execute(string $petName, GiveWaterDetails $details): void
    {
        dd(__CLASS__, $petName, $details);
    }
}
