<?php

declare(strict_types=1);

namespace App\Exception\DailyQuote;

use Exception;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;

#[WithHttpStatus(500)]
class CannotSelectAnyQuoteException extends Exception {}
