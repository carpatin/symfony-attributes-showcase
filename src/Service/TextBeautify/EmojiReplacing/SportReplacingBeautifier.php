<?php

declare(strict_types=1);

namespace App\Service\TextBeautify\EmojiReplacing;

use App\Service\TextBeautify\EmojiReplacingBeautifierInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(index: 'sport_replacing', priority: 180)]
class SportReplacingBeautifier implements EmojiReplacingBeautifierInterface
{
    use EmojiReplaceTrait;

    private const array SPORTS = [
        'soccer'        => '⚽',     // U+26BD
        'basketball'    => '🏀',     // U+1F3C0
        'baseball'      => '⚾',     // U+26BE
        'softball'      => '🥎',     // U+1F94E
        'football'      => '🏈',     // U+1F3C8
        'rugby'         => '🏉',     // U+1F3C9
        'tennis'        => '🎾',     // U+1F3BE
        'volleyball'    => '🏐',     // U+1F3D0
        'ping-pong'     => '🏓',     // U+1F3D3
        'badminton'     => '🏸',     // U+1F3F8
        'cricket'       => '🏏',     // U+1F3CF
        'hockey'        => '🏒',     // U+1F3D2
        'lacrosse'      => '🥍',     // U+1F94D
        'golf'          => '⛳',     // U+26F3
        'bowling'       => '🎳',     // U+1F3B3
        'boxing'        => '🥊',     // U+1F94A
        'martial arts'  => '🥋',     // U+1F94B
        'fencing'       => '🤺',     // U+1F93A
        'archery'       => '🏹',     // U+1F3F9
        'skate'         => '⛸️',     // U+26F8
        'ski'           => '🎿',     // U+1F3BF
        'sled'          => '🛷',     // U+1F6F7
        'surfing'       => '🏄',     // U+1F3C4
        'swimming'      => '🏊',     // U+1F3CA
        'diving'        => '🤿',     // U+1F93F
        'cycling'       => '🚴',     // U+1F6B4
        'mountain bike' => '🚵',     // U+1F6B5
        'running'       => '🏃',     // U+1F3C3
        'weightlifting' => '🏋️',     // U+1F3CB
        'wrestling'     => '🤼',     // U+1F93C
        'gymnastics'    => '🤸',     // U+1F938
        'juggling'      => '🤹',     // U+1F939
        'trophy'        => '🏆',     // U+1F3C6
        'gold medal'    => '🥇',     // U+1F947
        'silver medal'  => '🥈',     // U+1F948
        'bronze_medal'  => '🥉',     // U+1F949
    ];

    public function beautify(string $text): string
    {
        return $this->replaceEmojis($text, self::SPORTS);
    }
}
