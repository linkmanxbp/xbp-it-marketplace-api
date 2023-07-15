<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Response;
use App\Entity\ResponseUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ResponseFixtures extends Fixture implements DependentFixtureInterface
{
    public function getData(): array
    {
        return [
            //'author' => 3,
            'profile' => 8,
            'response_to_mission' => 1
        ];
    }

    public function getDependencies()
    {
        return [MissionFixtures::class, ProfileFixtures::class, UserFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $data = $this->getData();

        //$author = $manager->getRepository(User::class)->find($data['author']);
        $profile = $manager->getRepository(Ad::class)->find($data['profile']);
        $mission = $manager->getRepository(Ad::class)->find($data['response_to_mission']);

        $response = new Response();
        $response->setAuthor($profile->getUser());
        $manager->persist($response);

        //
        $responseUser = new ResponseUser();
        $responseUser->setResponse($response);
        $responseUser->setUser($profile->getUser());
        $responseUser->setAd($profile);
        $manager->persist($responseUser);

        $responseUser = new ResponseUser();
        $responseUser->setResponse($response);
        $responseUser->setUser($mission->getUser());
        $responseUser->setAd($mission);
        $manager->persist($responseUser);

        $manager->flush();
    }
}