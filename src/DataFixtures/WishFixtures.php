<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Wish;
use Carbon\Carbon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class WishFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {}

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
            $wish->setCreatedAt(Carbon::now());
            $wish->setUserIP($faker->ipv4);
            $wish->setUserBrowser($faker->randomElement(['Chrome 115.0', 'Safari 16.5', 'Firefox 115.0']));

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
