<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const NB_CATEGORIES = 4;
    private const NB_ARTICLES = 50;
    private const NB_USERS = 20;


    // public function __construct(
    //     private UserPasswordHasherInterface $hasher
    // ) {
    // }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $regularUser = new User();
        $regularUser
            ->setEmail("bob@bob.com")
            // ->setPassword('test');
            ->setPassword($this->hasher->hashPassword($regularUser, 'test'));

        $manager->persist($regularUser);

        $otherRegularUser = new User();
        $otherRegularUser
            ->setEmail("johnny@bob.com")
            ->setPassword('test');

        $manager->persist($otherRegularUser);

        // for ($i = 0; $i < self::NB_USERS; $i++) {

        //     $RegularUser = new User();
        //     $regularUser
        //         ->setEmail($faker->safeEmail())
        //         ->setPassword($this->hasher->hashPassword($regularUser, $faker->password()));

        //     $manager->persist($regularUser);
        // }

        $adminUser = new User();

        $adminUser
            ->setEmail("admin@domain.com")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('test');

        $manager->persist($adminUser);

        $users = [$regularUser, $adminUser];

        // $categories = [];                                     #pour initialiser les catégories, on crée une catégorie, on peut mettre à boucle
        for ($i = 0; $i < self::NB_CATEGORIES; $i++) {
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
                ->setCategory($faker->randomElement($categories))      # $faker->randomElement($categories) to select a random Category object from the $categories array
                ->setAuthor($faker->randomElement($users));

            $manager->persist($article);
        }
        $manager->flush();




        // $password = $faker->password;
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // for ($i = 0; $i < self::NB_USERS; $i++) {
        //     $roles = [ROLE_USER, ROLE_ADMIN];
        //     $admin = new User();

        //     $admin->setPassword($hashedPassword);
        //     $admin->setEmail($faker->email, $i, '@admin.com');
        //     $admin->setPassword($faker->password);
        //     $admin->setRoles($faker->randomElement($roles));
        //     $manager->persist($admin);



        //     $user_ordinary = new User();
        //     $user_ordinary->setEmail($faker->email, $i, '@user.com');
        //     $user_ordinary->setPassword($faker->password);
        //     $user_ordinary->setRoles($faker->randomElement($roles));
        //     $manager->persist($user_ordinary);

        //     $manager->flush();
        // }
    }
}
