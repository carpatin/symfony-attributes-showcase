<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class PhotoHandlingExtensionRuntime implements RuntimeExtensionInterface
{
    public function streamGetContents($stream): string
    {
        return stream_get_contents($stream);
    }

    public function base64Encode($value): string
    {
        return base64_encode($value);
    }
}
