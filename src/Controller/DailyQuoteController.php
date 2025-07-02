<?php

namespace App\Controller;

use App\DailyQuote\HighLikesSelector;
use App\DailyQuote\QuoteSelectorInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quote')]
final class DailyQuoteController extends AbstractController
{
    #[Route('/random')]
    #[Template('daily_quote/index.html.twig')]
    public function random(QuoteSelectorInterface $selector): array
    {
        $quote = $selector->select();

        return [
            'quote' => $quote,
        ];
    }

    #[Route('/liked')]
    public function liked(
        #[Autowire(service: HighLikesSelector::class)]
        QuoteSelectorInterface $selector,
    ): Response {
        print get_class($selector);
        $quote = $selector->select();

        return $this->render('daily_quote/index.html.twig', [
            'quote' => $quote,
        ]);
    }
}
