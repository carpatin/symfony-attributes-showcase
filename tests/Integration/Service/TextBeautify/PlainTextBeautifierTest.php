<?php

declare(strict_types=1);

namespace App\Tests\Integration\Service\TextBeautify;

use App\Service\TextBeautify\PlainTextBeautifier;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlainTextBeautifierTest extends KernelTestCase
{
    #[DataProvider('beautifyDataProvider')]
    public function testBeautify(string $inputText, string $expectedText): void
    {
        $kernel = self::bootKernel();

        $plainTextBeautifier = static::getContainer()->get(PlainTextBeautifier::class);
        $outputText = $plainTextBeautifier->beautify($inputText);

        $this->assertSame($expectedText, $outputText);

        $kernel->shutdown();
    }

    public static function beautifyDataProvider(): iterable
    {
        yield 'regular text + hearts padding' => ['beautiful day', '❤beautiful day❤'];
        yield 'regular text with various casing + hearts padding' => ['Beautiful Day', '❤Beautiful Day❤'];
        yield 'text with animals as singular + hearts padding' => ['dog camel mouse fish', '❤🐶 🐫 🐭 🐟❤'];
        yield 'text with animals as singular various case + hearts padding' => ['DOG Camel MoUsE FisH', '❤🐶 🐫 🐭 🐟❤'];
        yield 'text with animals as plural + hearts padding' => ['mice fishes', '❤🐭🐭🐭 fishes❤'];
        yield 'text with fruit as singular + hearts padding' => ['banana kiwi tangerine', '❤🍌 🥝 🍊❤'];
        yield 'text with fruit as plural + hearts padding' => ['bananas kiwis tangerines', '❤🍌🍌🍌 🥝🥝🥝 🍊🍊🍊❤'];
        yield 'text with sport + hearts padding' => ['I like playing badminton!', '❤I like playing 🏸!❤'];
    }
}
