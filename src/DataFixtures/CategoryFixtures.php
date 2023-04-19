<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public const NB_CATEGORIES = 4;
    public const CATEGORIES_PER_PPREFIX = 'CATEGORY_';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // $categories = [];                                #pour initialiser les catégories, on crée une catégorie, on peut mettre à boucle
        for ($i = 0; $i < self::NB_CATEGORIES; $i++) {
            $category = new Category();

            $category
                ->setName($faker->realText(20))
                ->setDescription($faker->realTextBetween(50, 100));
            $this->addReference(self::CATEGORIES_PER_PPREFIX . $i, $category);


            $manager->persist($category);
        }

        $manager->flush();
    }
}
