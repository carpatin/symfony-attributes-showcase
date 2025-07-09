<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\PhotoHandlingExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PhotoHandlingExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('stream_get_contents', [PhotoHandlingExtensionRuntime::class, 'streamGetContents']),
            new TwigFilter('base64_encode', [PhotoHandlingExtensionRuntime::class, 'base64Encode']),
        ];
    }
}
