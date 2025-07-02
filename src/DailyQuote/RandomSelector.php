<?php

declare(strict_types=1);

namespace App\DailyQuote;

use App\Dto\Quote;
use App\Repository\QuoteRepository;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias]
class RandomSelector implements QuoteSelectorInterface
{
    public function __construct(
        private readonly QuoteRepository $quoteRepo,
    ) {}

    public function select(): Quote
    {
        $quote = $this->quoteRepo->findRandom();

        return new Quote($quote->getText(), $quote->getAuthor()->getName());
    }
}
