<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Twig\Attribute\AsTwigFilter;

// The newer way of adding Twig filters, functions or tests, using attributes on plain services
class EncodingExtension
{
    // A filter added using the AsTwigFilter attribute
    #[AsTwigFilter('base64_encode')]
    public function base64Encode($value): string
    {
        return base64_encode($value);
    }
}
