<?php

declare(strict_types=1);

namespace App\Service\TextBeautify;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.padding_text_beautifier')]
interface PaddingTextBeautifierInterface extends BeautifierInterface
{
    public static function getIndex(): string;

    public static function getPriority(): int;
}
