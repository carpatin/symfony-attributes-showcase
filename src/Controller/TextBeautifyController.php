<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\TextBeautify\BeautifyInput;
use App\Service\TextBeautify\BeautifierInterface;
use App\Service\TextBeautify\PlainTextBeautifier;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/beautify')]
class TextBeautifyController extends AbstractController
{
    #[Route('/', name: 'app_text_beautify_index', methods: ['GET'])]
    #[Template('text_beautify/index.html.twig')]
    public function index(): array
    {
        return [];
    }

    // Example usages of #[AutowireIterator] introduced in Symfony 6.4 that allows you to inject iterable argument of
    // tagged services (in constructors or controller actions directly) without the need to configure anything in
    // services.yaml.

    #[Route('/emoji', name: 'app_text_beautify_emoji', methods: ['POST'])]
    #[Template('text_beautify/outcome.html.twig')]
    public function beautifyEmoji(
        #[MapRequestPayload]
        BeautifyInput $beautifyInput,
        #[AutowireIterator(
            tag: 'app.emoji_text_beautifier', // tag autoconfigured by implementing EmojiReplacingBeautifierInterface
            // Although the keys are defined through the #[AsTaggedItem(index: ...)] attribute argument,
            // the following is still needed so that the string keys defined with the AsTaggedItem are used instead of
            // numeric keys
            indexAttribute: 'index'

        )]
        iterable $textBeautifiers,
    ): array {
        $text = $beautifyInput->getText();
        [$text, $applied] = $this->beautifyText($text, $textBeautifiers);

        return ['outcome' => $text, 'applied' => $applied];
    }

    #[Route('/html', name: 'app_text_beautify_html', methods: ['POST'])]
    #[Template('text_beautify/outcome.html.twig')]
    public function beautifyHtml(
        #[MapRequestPayload]
        BeautifyInput $beautifyInput,
        #[AutowireIterator(
            tag: 'app.html_text_beautifier', // tag autoconfigured in classes from App\Service\TextBeautify\HtmlTagging
            // Although the keys are defined through the #[AsTaggedItem(index: ...)] attribute argument,
            // the following is still needed so that the string keys defined with the AsTaggedItem are used instead of
            // numeric keys
            indexAttribute: 'index'
        )]
        iterable $textBeautifiers,
    ): array {
        $text = $beautifyInput->getText();
        [$text, $applied] = $this->beautifyText($text, $textBeautifiers);

        return ['outcome' => $text, 'applied' => $applied];
    }

    #[Route('/padding', name: 'app_text_beautify_padding', methods: ['POST'])]
    #[Template('text_beautify/outcome.html.twig')]
    public function beautifyPadding(
        #[MapRequestPayload]
        BeautifyInput $beautifyInput,
        #[AutowireIterator(
            tag: 'app.padding_text_beautifier', // tag autoconfigured by implementing PaddingTextBeautifierInterface
            // the keys are defined through getters, the same for priorities
            defaultIndexMethod: 'getIndex',
            defaultPriorityMethod: 'getPriority',
        )]
        iterable $textBeautifiers,
    ): array {
        $text = $beautifyInput->getText();
        [$text, $applied] = $this->beautifyText($text, $textBeautifiers);

        return ['outcome' => $text, 'applied' => $applied];
    }

    #[Route('/plain', name: 'app_text_beautify_plain', methods: ['POST'])]
    #[Template('text_beautify/outcome.html.twig')]
    public function beautifyPlain(
        #[MapRequestPayload]
        BeautifyInput $beautifyInput,
        // In this example, we use a composite beautifier that is injected normally and called
        PlainTextBeautifier $beautifier,
    ): array {
        $text = $beautifyInput->getText();

        return ['outcome' => $beautifier->beautify($text), 'applied' => ['plain_text']];
    }

    /**
     * @param iterable<string, BeautifierInterface> $beautifiers
     */
    private function beautifyText(string $text, iterable $beautifiers): array
    {
        $applied = [];
        foreach ($beautifiers as $key => $beautifier) {
            $text = $beautifier->beautify($text);
            $applied[] = $key;
        }

        return [$text, $applied];
    }
}
