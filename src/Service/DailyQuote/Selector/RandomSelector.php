<?php

declare(strict_types=1);

namespace App\Service\DailyQuote\Selector;

use App\Dto\DailyQuote\Quote;
use App\Exception\DailyQuote\CannotSelectAnyQuoteException;
use App\Repository\QuoteRepository;
use App\Service\DailyQuote\QuoteSelectorInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

// Example of using the #[AsAlias] attribute on a service class to make it the autowired type
// when other services inject an object belonging to the interface (i.e. QuoteSelectorInterface).
#[AsAlias]
readonly class RandomSelector implements QuoteSelectorInterface
{
    public function __construct(
        private QuoteRepository $quoteRepo,
    ) {}

    /**
     * @throws CannotSelectAnyQuoteException
     */
    public function select(): Quote
    {
        $quote = $this->quoteRepo->findRandom();

        if (null === $quote) {
            throw new CannotSelectAnyQuoteException();
        }

        return new Quote(
            $quote->getId(),
            $quote->getText(),
            $quote->getLikes(),
            $quote->getAuthor()->getName(),
        );
    }
}
