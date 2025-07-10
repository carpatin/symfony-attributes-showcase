<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\StreamsExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

// The old way of defining Twig extensions, by extending the AbstractExtension and implementing methods
class StreamsExtension extends AbstractExtension
{
    // The filter is configured using a callable for a method in a runtime service
    public function getFilters(): array
    {
        return [
            new TwigFilter('stream_get_contents', [StreamsExtensionRuntime::class, 'streamGetContents']),
        ];
    }
}
