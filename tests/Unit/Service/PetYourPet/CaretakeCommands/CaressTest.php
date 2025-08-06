<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\PetYourPet\CaretakeCommands;

use App\Dto\PetYourPet\PetCaretake\CaressDetails;
use App\Entity\PetYourPet\Pet;
use App\Service\PetYourPet\CaretakeCommands\Caress;
use App\Service\PetYourPet\PetMood;
use App\Tests\Helper\ProtectedMembersHelperTrait;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ReflectionException;

class CaressTest extends TestCase
{
    use ProtectedMembersHelperTrait;

    private Caress $caressCommandMock;
    private Pet $pet;
    private MockObject|LoggerInterface $loggerMock;

    protected function setUp(): void
    {
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->caressCommandMock = $this
            ->getMockBuilder(Caress::class)
            ->onlyMethods(['getRandomInt'])
            ->getMock();
        $this->caressCommandMock->setLogger($this->loggerMock);
        $this->pet = new Pet();
        $this->pet->setName('Rex');
    }

    #[Test]
    public function itChangesPetStateWhenEnoughMinutes(): void
    {
        $this->pet
            ->setIsThirsty(false)
            ->setMood(PetMood::HYPER);
        $minutes = 5;
        $details = new CaressDetails($minutes);
        $this->caressCommandMock->method('getRandomInt')->willReturn(1); // ! important

        $this->loggerMock
            ->expects($this->exactly(2))
            ->method('info')
            ->willReturnCallback(function (string $message, array $context) use ($minutes) {
                if ($message === 'Caressing pet' &&
                    $context['pet_name'] === 'Rex' &&
                    $context['minutes'] === $minutes) {
                    return;
                }

                if ($message === 'Pet is relaxed' &&
                    $context['pet_name'] === 'Rex') {
                    return;
                }

                $this->fail(sprintf('Unexpected log message `%s`', $message));
            });

        $this->caressCommandMock->execute($this->pet, $details);

        $this->assertTrue($this->pet->isThirsty());
        $this->assertEquals(PetMood::RELAXED, $this->pet->getMood());
    }

    #[Test]
    public function itLeavesPetStateUnchangedWhenNotEnoughMinutes(): void
    {
        $this->pet
            ->setIsThirsty(false)
            ->setMood(PetMood::HYPER);
        $minutes = 1;
        $details = new CaressDetails($minutes);
        $this->caressCommandMock->method('getRandomInt')->willReturn(5); // ! important

        $this->loggerMock
            ->expects($this->exactly(2))
            ->method('info')
            ->willReturnCallback(function (string $message, array $context) use ($minutes) {
                if ($message === 'Caressing pet' &&
                    $context['pet_name'] === 'Rex' &&
                    $context['minutes'] === $minutes) {
                    return;
                }

                if ($message === 'Pet needs more caressing?' &&
                    $context['pet_name'] === 'Rex') {
                    return;
                }

                $this->fail(sprintf('Unexpected log message `%s`', $message));
            });

        $this->caressCommandMock->execute($this->pet, $details);

        $this->assertFalse($this->pet->isThirsty());
        $this->assertEquals(PetMood::HYPER, $this->pet->getMood());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetRandomInt(): void
    {
        $caressCommand = new Caress();
        $value = $this->invokeProtectedMethod($caressCommand, 'getRandomInt', [1, 10]);
        $this->assertGreaterThanOrEqual(1, $value);
        $this->assertLessThanOrEqual(10, $value);
    }
}
