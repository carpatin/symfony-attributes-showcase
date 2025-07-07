<?php

declare(strict_types=1);

namespace App\DailyQuote\Decorator;

use App\DailyQuote\QuoteSelectorInterface;
use App\Dto\DailyQuote\Quote;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

// Example usage of a decorator service: implements the same interface, and with the
// #[AsDecorator] attribute specifies what service it decorates and the priority.
// This will decorate directly a RandomSelector which is set to be #[AsAlias] for QuoteSelectorInterface.
#[AsDecorator(decorates: QuoteSelectorInterface::class, priority: 200)]
readonly class TitleCaseLettersDecorator implements QuoteSelectorInterface
{
    public function __construct(
        private QuoteSelectorInterface $quoteSelector,
    ) {}

    public function select(): Quote
    {
        $quote = $this->quoteSelector->select();
        $quoteText = ucwords($quote->quoteText);
        $authorName = ucwords($quote->authorName);

        return new Quote(
            $quote->quoteId,
            $quoteText,
            $quote->quoteLikes,
            $authorName,
        );
    }
}
