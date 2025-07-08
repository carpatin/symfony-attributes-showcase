<?php

namespace App\DataFixtures;

use App\Entity\DailyQuote\Author;
use App\Entity\DailyQuote\Quote;
use App\Entity\PetYourPet\Pet;
use App\Entity\User;
use App\Service\PetYourPet\PetMood;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use JsonException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const string QUOTES_FILE = '/data/quotes.json';

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        //
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('uploader@example.com');
        $user->setRoles(['ROLE_UPLOADER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $manager->persist($user);

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
