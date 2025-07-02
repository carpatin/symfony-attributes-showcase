<?php

declare(strict_types=1);

namespace App\TextBeautify\Html;

use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.text_beautifier')]
#[AsTaggedItem(index: 'html_bold_beautifier', priority: 10)]
class BoldHtmlBeautifier
{
    public function beautify(string $text): string
    {
        return "<b>".$text."</b>";
    }
}
