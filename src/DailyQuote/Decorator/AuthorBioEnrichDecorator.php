<?php

declare(strict_types=1);

namespace App\DailyQuote\Decorator;

use App\DailyQuote\QuoteSelectorInterface;
use App\Dto\DailyQuote\Quote;
use App\Repository\AuthorRepository;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

// Example usage of a decorator service: implements the same interface, and with the
// #[AsDecorator] attribute specifies what service it decorates and the priority.
// This will directly decorate a TitleCaseLettersDecorator because they both decorate the same service,
// identified by QuoteSelectorInterface, just that his one has a smaller priority, so it will be the outer decorator.
#[AsDecorator(decorates: QuoteSelectorInterface::class, priority: 100)]
readonly class AuthorBioEnrichDecorator implements QuoteSelectorInterface
{
    public function __construct(
        // Example of using #[Autowire()] attribute on a constructor argument to autowire a parameter
        #[Autowire('%env(APP_AUTHOR_NAME_PATTERN)%')]
        private string $authorNamePattern,
        private QuoteSelectorInterface $inner,
        private AuthorRepository $authorRepository,
    ) {}

    public function select(): Quote
    {
        $quote = $this->inner->select();
        // attempt to load the author entity
        $author = $this->authorRepository->findOneBy(['name' => $quote->authorName]);
        if ($author) {
            $authorName = sprintf(
                $this->authorNamePattern,
                $author->getName(),
                $author->getYearBornAsString() ?? 'N/A',
                $author->getYearDiedAsString() ?? 'N/A',
            );

            return new Quote(
                $quote->quoteId,
                $quote->quoteText,
                $quote->quoteLikes,
                $authorName,
            );
        }

        return $quote;
    }
}
