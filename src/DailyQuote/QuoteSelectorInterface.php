<?php

declare(strict_types=1);

namespace App\DailyQuote;

use App\Dto\DailyQuote\Quote;

/**
 * Declares a behavior of a service that selects a Quote based on its own rules then returns a
 * DTO object describing that entity, for usage in view templates.
 */
interface QuoteSelectorInterface
{
    public function select(): Quote;
}
