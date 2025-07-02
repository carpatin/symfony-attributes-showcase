<?php

declare(strict_types=1);

namespace App\DailyQuote;

use App\Dto\Quote;

interface QuoteSelectorInterface
{
    public function select(): Quote;
}
