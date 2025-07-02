<?php

declare(strict_types=1);

namespace App\TextBeautify\Html;

use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.text_beautifier')]
#[AsTaggedItem(index: 'html_italic_beautifier', priority: 15)]
class ItalicHtmlBeautifier
{
    public function beautify(string $text): string
    {
        return "<i>".$text."</i>";
    }
}
