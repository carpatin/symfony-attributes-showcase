<?php

declare(strict_types=1);

namespace App\Service\TextBeautify\EmojiReplacing;

use Symfony\Component\String\Inflector\EnglishInflector;

trait EmojiReplaceTrait
{
    private function replaceEmojis(string $text, array $emojis): string
    {
        $mappings = [];
        $inflector = new EnglishInflector();
        foreach ($emojis as $object => $emoji) {
            $plurals = $inflector->pluralize($object);
            $pluralMappings = array_combine($plurals, array_fill(0, count($plurals), str_repeat($emoji, 3)));
            $mappings = [...$mappings, ...$pluralMappings];
        }

        $mappings = [...$mappings, ...$emojis];

        return preg_replace(
            array_map(static fn($mapping) => '/\b'.$mapping.'\b/i', array_keys($mappings)),
            array_values($mappings),
            $text,
        );
    }
}
