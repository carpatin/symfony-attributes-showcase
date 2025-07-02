<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Pet;
use App\Entity\Quote;
use App\PetYourPet\PetMood;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Random\RandomException;

class AppFixtures extends Fixture
{
    private const QUOTES = [
        "Salt is born of the purest parents: the sun and the sea."                                       => "Pythagoras",
        "Destroying rainforest for economic gain is like burning a Renaissance painting to cook a meal." => "E.O. Wilson",
        "Life began with waking up and loving my mother's face."                                         => "George Eliot",
        "In the middle of every difficulty lies opportunity."                                            => "Albert Einstein",
        "It is never too late to be what you might have been."                                           => "George Eliot",
        "Be yourself; everyone else is already taken."                                                   => "Oscar Wilde",
        "Life is what happens when you're busy making other plans."                                      => "John Lennon",
        "You don't have to be great to start, but you have to start to be great."                        => "Zig Ziglar",
        "Success is stumbling from failure to failure with no loss of enthusiasm."                       => "Winston Churchill",
        "The only place where success comes before work is in the dictionary."                           => "Vidal Sassoon",
    ];

    /**
     * @throws RandomException
     */
    public function load(ObjectManager $manager): void
    {
        $authors = [];

        foreach (self::QUOTES as $quoteText => $authorName) {
            if (!isset($authors[$authorName])) {
                $author = new Author();
                $author->setName($authorName);
                $author->setYearBorn(random_int(1880, 1930));
                $author->setYearDied(random_int(1930, 2010));

                $manager->persist($author);
                $authors[$authorName] = $author;
            }
            $author = $authors[$authorName];

            $quote = new Quote();
            $quote->setText($quoteText);
            $quote->setAuthor($author);
            $quote->setLikes(random_int(1, 50));
            $quote->setCategory('Inspirational');
            $manager->persist($quote);
        }

        $faker = Factory::create();

        foreach (range(1, 100) as $i) {
            $pet = new Pet();
            $pet->setName($faker->unique()->firstName());
            $pet->setMood($faker->randomElement([PetMood::NORMAL, PetMood::APATHETIC, PetMood::HYPER]));
            $pet->setIsHungry($faker->boolean());
            $pet->setIsThirsty($faker->boolean());
            $manager->persist($pet);
        }

        $manager->flush();
    }
}
