<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;



class AppFixtures extends Fixture
{
    private const NB_CATEGORIES = 4;
    private const NB_ARTICLES = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // $categories = [];                                #pour initialiser les catégories, on crée une catégorie, on peut mettre à boucle
        for ($i = 0, $categories = []; $i < self::NB_CATEGORIES; $i++) {
            $category = new Category();
            $category
                ->setName($faker->realText(20))
                ->setDescription($faker->realTextBetween(50, 100));
            $manager->persist($category);
            $categories[] = $category;
        }
        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realText(35))
                ->setDateCreated($faker->dateTimeBetween('-2 years'))   #這裏可以用\dataTime 也可以將鼠標放在DateTime後面，然後ctrl+espace，出來幾個選項，這個時候選擇對的選項就可以
                ->setVisible($faker->boolean(80))    #c'est 80%
                ->setContent($faker->realTextBetween(200, 500))
                // ->setCategory($faker->randomElement($categories));      # $faker->randomElement($categories) to select a random Category object from the $categories array
                // ->setCategory($categories[array_rand($categories)]);
                ->setCategory($faker->$categories(0, self::NB_CATEGORIES - 1));

            $manager->persist($article);
        }

        $manager->flush();
    }
}
