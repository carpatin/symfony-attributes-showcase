<?php

declare(strict_types=1);

namespace App\Service\DailyQuote\Selector;

use App\Dto\DailyQuote\Quote;
use App\Exception\DailyQuote\CannotSelectAnyQuoteException;
use App\Repository\QuoteRepository;
use App\Service\DailyQuote\QuoteSelectorInterface;

readonly class MostLikesSelector implements QuoteSelectorInterface
{
    public function __construct(
        private QuoteRepository $quoteRepo,
    ) {
        //
    }

    /**
     * @throws CannotSelectAnyQuoteException
     */
    public function select(): Quote
    {
        $quote = $this->quoteRepo->findRandomHighlyLiked();

        if (null === $quote) {
            throw new CannotSelectAnyQuoteException();
        }

        return new Quote(
            $quote->getId(),
            $quote->getText(),
            $quote->getLikes(),
            $quote->getAuthor()?->getName() ?? 'Unknown',
        );
    }
}
