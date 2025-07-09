<?php

declare(strict_types=1);

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

#[AsEventListener('kernel.exception', method: 'onKernelException', priority: 300)]
class ExceptionListener
{


    /**
     */
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $this->logger->error('INTRA '.$exception->getMessage());

        if ($exception instanceof InvalidCsrfTokenException) {
            throw new BadRequestException('Invalid CSRF token. Please try again.');
        }
    }
}
