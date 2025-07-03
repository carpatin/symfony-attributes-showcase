<?php

declare(strict_types=1);

namespace App\Controller;

use App\DailyQuote\HighLikesSelector;
use App\DailyQuote\QuoteSelectorInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quote')]
class DailyQuoteController extends AbstractController
{
    #[Route('/', name: 'app_daily_quote_index', methods: ['GET'])]
    #[Template('daily_quote/index.html.twig')]
    public function index(QuoteSelectorInterface $selector): array
    {
        $quote = $selector->select();

        return [
            'quote' => $quote,
        ];
    }

    #[Route('/random', name: 'app_daily_quote_random', methods: ['GET'])]
    #[Template('daily_quote/random.html.twig')]
    public function random(QuoteSelectorInterface $selector): array
    {
        $quote = $selector->select();

        return [
            'quote' => $quote,
        ];
    }

    #[Route('/liked', name: 'app_daily_quote_liked', methods: ['GET'])]
    public function liked(
        #[Autowire(service: HighLikesSelector::class)]
        QuoteSelectorInterface $selector,
    ): Response {
        $quote = $selector->select();

        return $this->render('daily_quote/liked.html.twig', [
            'quote' => $quote,
        ]);
    }
}
