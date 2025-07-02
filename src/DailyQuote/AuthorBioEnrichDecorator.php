<?php

declare(strict_types=1);

namespace App\DailyQuote;

use App\Dto\Quote;
use App\Repository\AuthorRepository;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(decorates: QuoteSelectorInterface::class, priority: 20)]
class AuthorBioEnrichDecorator implements QuoteSelectorInterface
{
    public function __construct(
        private readonly QuoteSelectorInterface $inner,
        private readonly AuthorRepository $authorRepository,
    ) {}

    public function select(): Quote
    {
        $quote = $this->inner->select();
        // attempt to load the author entity
        $author = $this->authorRepository->findOneBy(['name' => $quote->authorName]);
        if ($author) {
            $quote->authorName = sprintf(
                '%s (%s - %s)',
                $author->getName(),
                $author->getYearBorn() ?? 'N/A',
                $author->getYearDied() ?? 'N/A',
            );
        }

        return $quote;
    }
}
