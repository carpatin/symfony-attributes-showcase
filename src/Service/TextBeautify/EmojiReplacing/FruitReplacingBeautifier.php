<?php

declare(strict_types=1);

namespace App\Service\TextBeautify\EmojiReplacing;

use App\Service\TextBeautify\EmojiReplacingBeautifierInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(index: 'fruit_replacing', priority: 190)]
class FruitReplacingBeautifier implements EmojiReplacingBeautifierInterface
{
    use EmojiReplaceTrait;

    private const array FRUITS = [
        'grapes'      => '🍇', // U+1F347
        'melon'       => '🍈', // U+1F348
        'watermelon'  => '🍉', // U+1F349
        'tangerine'   => '🍊', // U+1F34A
        'lemon'       => '🍋', // U+1F34B
        'banana'      => '🍌', // U+1F34C
        'pineapple'   => '🍍', // U+1F34D
        'mango'       => '🥭', // U+1F96D
        'apple'       => '🍎', // U+1F34E
        'red_apple'   => '🍎', // U+1F34E
        'green_apple' => '🍏', // U+1F34F
        'pear'        => '🍐', // U+1F350
        'peach'       => '🍑', // U+1F351
        'cherries'    => '🍒', // U+1F352
        'strawberry'  => '🍓', // U+1F353
        'kiwi'        => '🥝', // U+1F95D
        'tomato'      => '🍅', // U+1F345
        'coconut'     => '🥥', // U+1F965
        'avocado'     => '🥑', // U+1F951
        'blueberries' => '🫐', // U+1FAD0
        'olive'       => '🫒', // U+1FAD2
    ];

    public function beautify(string $text): string
    {
        return $this->replaceEmojis($text, self::FRUITS);
    }
}
