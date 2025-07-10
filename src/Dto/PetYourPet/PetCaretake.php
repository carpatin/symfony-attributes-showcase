<?php

declare(strict_types=1);

namespace App\Dto\PetYourPet;

use App\Dto\PetYourPet\PetCaretake\CaressDetails;
use App\Dto\PetYourPet\PetCaretake\GiveFoodDetails;
use App\Dto\PetYourPet\PetCaretake\GiveWaterDetails;
use App\Dto\PetYourPet\PetCaretake\PlayDetails;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;

class PetCaretake
{
    public const string COMMAND_GIVE_WATER = 'give_water';
    public const string COMMAND_GIVE_FOOD  = 'give_food';
    public const string COMMAND_CARESS     = 'caress';
    public const string COMMAND_PLAY       = 'play';

    public function __construct(
        #[Assert\NotBlank(message: 'Pet name cannot be blank')]
        #[Assert\Length(
            min: 2,
            max: 50,
            minMessage: 'Pet name must be at least {{ limit }} characters long',
            maxMessage: 'Pet name cannot be longer than {{ limit }} characters'
        )]
        #[Assert\Regex(
            pattern: '/^[a-zA-Z0-9\-\s]+$/',
            message: 'Pet name can only contain letters, numbers, spaces, and hyphens'
        )]
        public string $name,

        #[Assert\NotBlank(message: 'Command cannot be blank')]
        #[Assert\Choice(
            choices: [
                self::COMMAND_GIVE_WATER,
                self::COMMAND_GIVE_FOOD,
                self::COMMAND_CARESS,
                self::COMMAND_PLAY,
            ],
            message: 'Please choose a valid command'
        )]
        public string $command,

        #[Assert\Valid]
        public GiveWaterDetails $giveWaterCaretake,

        #[Assert\Valid]
        public GiveFoodDetails $giveFoodCaretake,

        #[Assert\Valid]
        public CaressDetails $caressCaretake,

        #[Assert\Valid]
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
