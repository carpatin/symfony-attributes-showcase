<?php

declare(strict_types=1);

namespace App\Service\TextBeautify;

use App\Service\TextBeautify\HtmlTagging\BoldTextBeautifier;
use App\Service\TextBeautify\HtmlTagging\ItalicTextBeautifier;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

#[AsTaggedItem(index: 'plain_text', priority: 300)]
class PlainTextBeautifier implements BeautifierInterface
{
    public function __construct(
        #[AutowireIterator(
            // Reference the tag that unifies all text beautifiers, namely tho one set by the BeautifierInterface
            tag: 'app.text_beautifier',
            // The following two are needed only for the services that do not provide index and priority through
            // the #[AsTaggedItem] attribute, for the others they will be taken from the attribute on their classes.
            defaultIndexMethod: 'getIndex',
            defaultPriorityMethod: 'getPriority',
            // Excluding the beautifiers that add HTML tags
            exclude: [BoldTextBeautifier::class, ItalicTextBeautifier::class],
            excludeSelf: true // I believe is true by default, if set to true it enters recursion
        )]
        private iterable $beautifiers,
    ) {}

    public function beautify(string $text): string
    {
        return array_reduce(
            iterator_to_array($this->beautifiers),
            static fn(string $carry, BeautifierInterface $beautifier) => $beautifier->beautify($carry),
            $text,
        );
    }
}
