<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\TextBeautify\BeautificationInput;
use App\TextBeautify\Html\BoldHtmlBeautifier;
use App\TextBeautify\Html\ItalicHtmlBeautifier;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

/**
 * This controller and related services are used to demonstrate the use of the attributes:
 * - AutowireIterator
 * - AutoconfigureTag
 * - AsTaggedItem
 * - MapRequestPayload
 */
#[Route('/beautify')]
class TextBeautifyController extends AbstractController
{
    #[Route('/', name: 'app_text_beautify_index', methods: ['GET'])]
    #[Template('text_beautify/index.html.twig')]
    public function index(): array
    {
        return [];
    }

    #[Route('/', methods: ['POST'])]
    #[Template('text_beautify/outcome.html.twig')]
    public function beautify(
        #[MapRequestPayload]
        BeautificationInput $payload,
        #[AutowireIterator(
            tag: 'app.text_beautifier',
            indexAttribute: 'index',
            defaultIndexMethod: 'getIteratorIndex',
            defaultPriorityMethod: 'getIteratorPriority',
            exclude: [BoldHtmlBeautifier::class, ItalicHtmlBeautifier::class],
            excludeSelf: true
        )]
        iterable $textBeautifiers,
    ): array {
        $text = $payload->getText();
        $applied = [];
        foreach ($textBeautifiers as $key => $textBeautifier) {
            $text = $textBeautifier->beautify($text);
            $applied[] = $key;
        }

        return ['outcome' => $text, 'applied' => $applied];
    }
}
