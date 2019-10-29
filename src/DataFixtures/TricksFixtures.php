<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Tricks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class TricksFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //3 catégories fakées
        for($i = 1; $i <= 3; $i++) {
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());

            $manager->persist($category);

            //Créer etre 4 et 6 tricks

        
        for($j = 1; $j <= mt_rand(4, 6); $j++ ){
            $tricks = new Tricks();

            $content = '<p>' . join($faker->paragraphs(5), '</p><p>') .
            '</p>';
            

            $tricks->setName($faker->sentence())
                    ->setdescription($content)
                    ->setillustration($faker->imageUrl())
                    ->setCategory($category);
                $manager->persist($tricks);

                // On donne des commentaires aux tricks
                for($k = 1; $k <= mt_rand(4, 10); $k++) {
                    $comment = new Comment();

                $content = '<p>' . join($faker->paragraphs(2), '</p><p>') .
                '</p>';
                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                            ->setTrick($tricks);

                $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
