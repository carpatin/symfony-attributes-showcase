<?php

declare(strict_types=1);

namespace App\Service\TextBeautify\EmojiReplacing;

use App\Service\TextBeautify\EmojiReplacingBeautifierInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(index: 'animal_replacing', priority: 200)]
class AnimalReplacingBeautifier implements EmojiReplacingBeautifierInterface
{
    use EmojiReplaceTrait;

    private const array ANIMALS = [
        'monkey'    => '🐒',       // U+1F412
        'gorilla'   => '🦍',      // U+1F98D
        'dog'       => '🐶',          // U+1F436
        'poodle'    => '🐩',       // U+1F429
        'wolf'      => '🐺',         // U+1F43A
        'fox'       => '🦊',          // U+1F98A
        'cat'       => '🐱',          // U+1F431
        'lion'      => '🦁',         // U+1F981
        'tiger'     => '🐯',        // U+1F42F
        'leopard'   => '🐆',      // U+1F406
        'horse'     => '🐴',        // U+1F434
        'unicorn'   => '🦄',      // U+1F984
        'zebra'     => '🦓',        // U+1F993
        'cow'       => '🐮',          // U+1F42E
        'pig'       => '🐷',          // U+1F437
        'ram'       => '🐏',          // U+1F40F
        'goat'      => '🐐',         // U+1F410
        'camel'     => '🐫',        // U+1F42B
        'elephant'  => '🐘',     // U+1F418
        'mouse'     => '🐭',        // U+1F42D
        'rabbit'    => '🐰',       // U+1F430
        'bear'      => '🐻',         // U+1F43B
        'koala'     => '🐨',        // U+1F428
        'panda'     => '🐼',        // U+1F43C
        'kangaroo'  => '🦘',     // U+1F998
        'turkey'    => '🦃',       // U+1F983
        'chicken'   => '🐔',      // U+1F414
        'penguin'   => '🐧',      // U+1F427
        'bird'      => '🐦',         // U+1F426
        'duck'      => '🦆',         // U+1F986
        'owl'       => '🦉',          // U+1F989
        'frog'      => '🐸',         // U+1F438
        'crocodile' => '🐊',    // U+1F40A
        'turtle'    => '🐢',       // U+1F422
        'snake'     => '🐍',        // U+1F40D
        'dolphin'   => '🐬',      // U+1F42C
        'whale'     => '🐳',        // U+1F433
        'fish'      => '🐟',         // U+1F41F
        'octopus'   => '🐙',      // U+1F419
        'crab'      => '🦀',         // U+1F980
        'butterfly' => '🦋',    // U+1F98B
        'snail'     => '🐌',        // U+1F40C
        'ant'       => '🐜',          // U+1F41C
        'bee'       => '🐝',          // U+1F41D
        'ladybug'   => '🐞',      // U+1F41E
    ];

    public function beautify(string $text): string
    {
        return $this->replaceEmojis($text, self::ANIMALS);
    }
}
