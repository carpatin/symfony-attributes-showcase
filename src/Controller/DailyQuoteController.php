<?php

declare(strict_types=1);

namespace App\Controller;

use App\DailyQuote\QuoteSelectorInterface;
use App\DailyQuote\Selector\MostLikesSelector;
use App\Entity\Author;
use App\Entity\Quote;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/daily-quote')]
class DailyQuoteController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        //
    }

    #[Route('/', name: 'app_daily_quote_index', methods: ['GET'])]
    #[Template('daily_quote/index.html.twig')]
    public function index(): array
    {
        return [];
    }

    #[Route('/authors', name: 'app_daily_quote_list_authors', methods: ['GET'])]
    #[Template('daily_quote/list_authors.html.twig')]
    public function listAuthors(
        // The mapping of the lists of entities was introduced in Symfony 7.1.
        #[MapEntity(class: Author::class, expr: 'repository.findAllPaginated()')]
        Pagerfanta $authors,
        #[MapQueryParameter(filter: FILTER_VALIDATE_INT)]
        int $page = 1,
    ): array {
        $authors->setMaxPerPage(10);
        $authors->setCurrentPage($page);

        return ['authors' => $authors];
    }

    #[Route('/authors/{name}/quotes', name: 'app_daily_quote_list_by_author', methods: ['GET'])]
    #[Template('daily_quote/list_by_author.html.twig')]
    public function listQuotesByAuthor(
        // Another option:
        // `#[MapEntity(expr: 'repository.findOneBy({"name": name})')]`
        #[MapEntity(mapping: ['name' => 'name'])]
        Author $author,
        #[MapEntity(class: Quote::class, expr: 'repository.findByAuthorName(name)')]
        iterable $quotes,
    ): array {
        return [
            'author' => $author,
            'quotes' => $quotes,
        ];
    }

    #[Route('/quote/random', name: 'app_daily_quote_random', methods: ['GET'])]
    #[Template('daily_quote/random.html.twig')]
    public function random(QuoteSelectorInterface $selector): array
    {
        return [
            'quote' => $selector->select(),
        ];
    }

    #[Route('/quote/liked', name: 'app_daily_quote_liked', methods: ['GET'])]
    #[Template('daily_quote/liked.html.twig')]
    public function liked(
        // Example of autowiring another service than the one aliased for QuoteSelectorInterface
        // by using the fully qualified name
        #[Autowire(service: MostLikesSelector::class)]
        QuoteSelectorInterface $selector,
    ): array {
        return [
            'quote' => $selector->select(),
        ];
    }

    #[Route('/quote/one', name: 'app_daily_quote_one', methods: ['GET'])]
    #[Template('daily_quote/one.html.twig')]
    public function one(
        #[Autowire(expression: 'service("App\\\\DailyQuote\\\\QuoteSelectorResolver").resolveToSelector(env("APP_QUOTE_SELECTOR"))')]
        QuoteSelectorInterface $selector,
    ): array {
        return [
            'quote' => $selector->select(),
        ];
    }

    #[Route('/quote/{id}/like', name: 'app_daily_quote_like', methods: ['POST'])]
    public function like(
        Quote $quote,
    ): Response {
        $quote->setLikes($quote->getLikes() + 1);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_daily_quote_list_by_author', [
            'name' => $quote->getAuthor()->getName(),
        ]);
    }
}
