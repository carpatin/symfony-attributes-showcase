<?php

declare(strict_types=1);

namespace App\Service\DailyQuote;

use App\Service\DailyQuote\Selector\MostLikesSelector;
use App\Service\DailyQuote\Selector\RandomSelector;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class QuoteSelectorResolver
{
    public function __construct(
        #[Autowire(service: RandomSelector::class)]
        private QuoteSelectorInterface $randomSelector,
        #[Autowire(service: MostLikesSelector::class)]
        private QuoteSelectorInterface $likesSelector,
    ) {
        //
    }

    public function resolveToSelector(string $configuredSelector): QuoteSelectorInterface
    {
        return match ($configuredSelector) {
            'random' => $this->randomSelector,
            'likes' => $this->likesSelector,
            default => throw new \InvalidArgumentException(sprintf('Invalid selector "%s".', $configuredSelector)),
        };
    }
}
