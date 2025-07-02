<?php

declare(strict_types=1);

namespace App\PetYourPet;

enum PetMood: string
{
    case NORMAL = 'normal';
    case APATHETIC = 'apathetic';
    case HYPER = 'hyper';
}
