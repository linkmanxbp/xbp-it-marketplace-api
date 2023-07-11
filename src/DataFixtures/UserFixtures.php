<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $password_hasher)
    {

    }

    private function getData(): array
    {
        return [
            ['Xavier', 'Buisson', 'admin@xbp.fr', 'passw', ['ROLE_ADMIN']],
            ['Marguerite', 'Rousseau', 'mr@xbp.fr', 'passw', ['ROLE_USER']],
            ['Camille ', 'Barbe', 'cr@xbp.fr', 'passw', ['ROLE_USER']],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $i = 1;
        foreach ($this->getData() as [$name, $last_name, $email, $password, $roles]) {
            $user = new User();
            $user->setName($name);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $user->setRoles($roles);

            $password = $this->password_hasher->hashPassword($user, $password);
            $user->setPassword($password);

            $this->setReference('user_' . $i, $user);

            $manager->persist($user);
        }

        $manager->flush();
    }
}