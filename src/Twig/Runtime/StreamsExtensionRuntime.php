<?php

declare(strict_types=1);

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class StreamsExtensionRuntime implements RuntimeExtensionInterface
{
    public function streamGetContents($stream): string
    {
        return stream_get_contents($stream);
    }
}
