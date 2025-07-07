<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Pet;
use App\Entity\Quote;
use App\Service\PetYourPet\PetMood;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use JsonException;
use Random\RandomException;

class AppFixtures extends Fixture
{
    private const string QUOTES_FILE = '/data/quotes.json';

    /**
     * @throws RandomException
     * @throws JsonException
     */
    public function load(ObjectManager $manager): void
    {
        $authors = [];
        foreach ($this->loadQuotesFromFile() as $quoteData) {
            [
                'quote_text'        => $quoteText,
                'quote_category'    => $quoteCategory,
                'author_name'       => $authorName,
                'author_birth_year' => $authorBirthYear,
                'author_death_year' => $authorDeathYear,
            ] = $quoteData;

            if (!isset($authors[$authorName])) {
                $author = new Author();
                $author->setName($authorName);
                $author->setYearBorn($authorBirthYear);
                $author->setYearDied($authorDeathYear);

                $manager->persist($author);
                $authors[$authorName] = $author;
            }
            $author = $authors[$authorName];

            $quote = new Quote();
            $quote->setText($quoteText);
            $quote->setAuthor($author);
            $quote->setLikes(0);
            $quote->setCategory($quoteCategory);
            $manager->persist($quote);
        }

        $faker = Factory::create();

        foreach (range(1, 100) as $i) {
            $pet = new Pet();
            $pet->setName($faker->unique()->firstName());
            $pet->setMood($faker->randomElement([PetMood::RELAXED, PetMood::APATHETIC, PetMood::HYPER]));
            $pet->setIsHungry($faker->boolean());
            $pet->setIsThirsty($faker->boolean());
            $manager->persist($pet);
        }

        $manager->flush();
    }

    /**
     * @throws JsonException
     */
    private function loadQuotesFromFile(): array
    {
        $filePath = __DIR__.self::QUOTES_FILE;
        if (!file_exists($filePath)) {
            return [];
        }

        $jsonContent = file_get_contents($filePath);
        if ($jsonContent === false) {
            return [];
        }

        $quotes = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($quotes)) {
            return [];
        }

        return $quotes;
    }
}
