<?php

declare(strict_types=1);

namespace App\DailyQuote\Selector;

use App\DailyQuote\QuoteSelectorInterface;
use App\Dto\DailyQuote\Quote;
use App\Repository\QuoteRepository;

readonly class MostLikesSelector implements QuoteSelectorInterface
{
    public function __construct(
        private QuoteRepository $quoteRepo,
    ) {
        //
    }

    public function select(): Quote
    {
        $quote = $this->quoteRepo->findRandomHighlyLiked();

        return new Quote(
            $quote->getId(),
            $quote->getText(),
            $quote->getLikes(),
            $quote->getAuthor()?->getName() ?? 'Unknown',
        );
    }
}
