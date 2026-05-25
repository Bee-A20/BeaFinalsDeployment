<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->createUser($manager, 'admin', 'biangss1220@gmail.com', ['ROLE_ADMIN'], 'admin123');
        $this->createUser($manager, 'bealyn', 'bealynpacunla93@gmail.com', ['ROLE_USER'], 'user123');
        $this->createUser($manager, 'staff', 'lynziepacunla@gmail.com', ['ROLE_STAFF'], 'staff123');

        $manager->flush();
    }

    private function createUser(ObjectManager $manager, string $username, string $email, array $roles, string $password): void
    {
        $repository = $manager->getRepository(User::class);
        $existing = $repository->findOneBy(['email' => $email]) ?? $repository->findOneBy(['username' => $username]);
        if ($existing) {
            return;
        }

        $user = new User();
        $user->setUsername($username);
        $user->setRoles($roles);
        $user->setEmail($email);
        $user->setIsVerified(true);
        $user->setVerificationToken('');
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $manager->persist($user);
    }
}
