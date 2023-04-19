<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    private const NB_ARTICLES = 50;


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realText(35))
                ->setDateCreated($faker->dateTimeBetween('-2 years'))   #這裏可以用\dataTime 也可以將鼠標放在DateTime後面，然後ctrl+espace，出來幾個選項，這個時候選擇對的選項就可以
                ->setVisible($faker->boolean(80))    #c'est 80%
                ->setContent($faker->paragraphs(6, true))
                ->setCategory(
                    $this->getReference(
                        CategoryFixtures::CATEGORIES_PER_PPREFIX . $faker->numberBetween(1, CategoryFixtures::NB_CATEGORIES)
                    )
                );      # $faker->randomElement($categories) to select a random Category object from the $categories array
            // ->setCategory($categories[array_rand($categories)]);
            // ->setCategory($categories[$faker->numberBetween(0. count($categories)-1)]);
            // ->setCategory($faker->$categories(0, self::NB_CATEGORIES - 1));

            $manager->persist($article);
        }

        $manager->flush($article);
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
