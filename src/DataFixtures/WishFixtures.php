<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Wish;
use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class WishFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $itemsCount = 100;

        for ($i = 0; $i < $itemsCount; $i++) {
            $wish = new Wish();
            $wish->setUserName($faker->userName);
            $wish->setEmail($faker->email);
            $wish->setContent($faker->realTextBetween(100, 300));
            $wish->setIsModerated($faker->boolean);
            $wish->setCreatedAt(CarbonImmutable::now());

            if ($faker->boolean) {
                $wish->setHomePage($faker->url);
            }

            if ($faker->boolean) {
                $user = new User();
                $user->setUserName($wish->getUserName());
                $user->setEmail($wish->getEmail());
                $wish->setUser($user);

                $plainPassword = 'password';
                $hashedPassword = $this->hasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            $manager->persist($wish);
        }

        $manager->flush();
    }
}
