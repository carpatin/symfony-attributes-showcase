<?php

declare(strict_types=1);

namespace App\Service\TextBeautify\HtmlTagging;

use App\Service\TextBeautify\BeautifierInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.html_text_beautifier')]
#[AsTaggedItem(index: 'bold_text', priority: 100)]
class BoldTextBeautifier implements BeautifierInterface
{
    public function beautify(string $text): string
    {
        return "<b>".$text."</b>";
    }
}
