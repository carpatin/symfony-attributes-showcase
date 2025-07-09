<?php

namespace App\Twig\Components;

use App\Entity\PhotoAlbum\Photo;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'photo_item')]
final class PhotoItem
{
    public Photo $photo;
}
