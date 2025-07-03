<?php

declare(strict_types=1);

namespace App\Service\PetYourPet;

enum PetMood: string
{
    case RELAXED = 'relaxed';
    case APATHETIC = 'apathetic';
    case HYPER = 'hyper';
}
