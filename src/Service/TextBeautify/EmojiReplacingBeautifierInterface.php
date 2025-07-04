<?php

declare(strict_types=1);

namespace App\Service\TextBeautify;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.emoji_text_beautifier')]
interface EmojiReplacingBeautifierInterface extends BeautifierInterface
{
    //
}
