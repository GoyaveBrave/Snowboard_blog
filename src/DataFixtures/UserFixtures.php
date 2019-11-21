<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setUsername($faker->name())
                     ->setEmail($faker->email());

            $manager->persist($user);
            // $product = new Product();
        // $manager->persist($product);
        }
        $manager->flush();
    }
}
