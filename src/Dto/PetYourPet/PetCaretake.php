<?php

declare(strict_types=1);

namespace App\Dto\PetYourPet;

use App\Dto\PetYourPet\PetCaretake\CaressDetails;
use App\Dto\PetYourPet\PetCaretake\GiveFoodDetails;
use App\Dto\PetYourPet\PetCaretake\GiveWaterDetails;
use App\Dto\PetYourPet\PetCaretake\PlayDetails;
use Exception;

class PetCaretake
{
    public const string COMMAND_GIVE_WATER = 'give_water';
    public const string COMMAND_GIVE_FOOD  = 'give_food';
    public const string COMMAND_CARESS     = 'caress';
    public const string COMMAND_PLAY       = 'play';

    public function __construct(
        public string $name,
        public string $command,
        public GiveWaterDetails $giveWaterCaretake,
        public GiveFoodDetails $giveFoodCaretake,
        public CaressDetails $caressCaretake,
        public PlayDetails $playCaretake,
    ) {
        //
    }

    /**
     * @throws Exception
     */
    public function getCommandDetails(): PlayDetails|GiveFoodDetails|CaressDetails|GiveWaterDetails
    {
        return match ($this->command) {
            self::COMMAND_GIVE_WATER => $this->giveWaterCaretake,
            self::COMMAND_GIVE_FOOD => $this->giveFoodCaretake,
            self::COMMAND_CARESS => $this->caressCaretake,
            self::COMMAND_PLAY => $this->playCaretake,
            default => throw new Exception('Unknown command')
        };
    }
}
