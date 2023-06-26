<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends BaseFixtures
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(User::class, 10, function (User $user){
            $user
                ->setEmail($this->faker->email())
                ->setFirstName($this->faker->firstName)
                ->setRoles(['user'])
                ->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        });
        $this->createMany(User::class, 1, function (User $user){
            $user
                ->setEmail('eremeev87@bk.ru')
                ->setFirstName('Администратор')
                ->setRoles(['admin'])
                ->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        });

    }
}
