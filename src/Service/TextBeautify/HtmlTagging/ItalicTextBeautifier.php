<?php

declare(strict_types=1);

namespace App\Service\TextBeautify\HtmlTagging;

use App\Service\TextBeautify\BeautifierInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.html_text_beautifier')]
#[AsTaggedItem(index: 'italic_text', priority: 90)]
class ItalicTextBeautifier implements BeautifierInterface
{
    public function beautify(string $text): string
    {
        return "<i>".$text."</i>";
    }
}
