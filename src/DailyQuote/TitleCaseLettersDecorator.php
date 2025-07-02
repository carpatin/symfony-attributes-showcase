<?php

declare(strict_types=1);

namespace App\DailyQuote;

use App\Dto\Quote;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(decorates: QuoteSelectorInterface::class, priority: 100)]
class TitleCaseLettersDecorator implements QuoteSelectorInterface
{
    public function __construct(
        private QuoteSelectorInterface $quoteSelector,
    ) {}

    public function select(): Quote
    {
        $quote = $this->quoteSelector->select();
        $quote->quoteText = ucwords($quote->quoteText);
        $quote->authorName = ucwords($quote->authorName);

        return $quote;
    }
}
