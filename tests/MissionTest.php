<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\Mission;
use App\Entity\User;
use Doctrine\ORM\EntityManager;

class MissionTest extends ApiTestCase
{
    private Client $client;
    private EntityManager $entityManager;

    private function getData(): array
    {
        return [
            'title' => 'Mission Test',
            'description' => 'Mission Description Test',
            //'user' => '/api/users/2' Don't need it anymore thanks to AddOwnerSubscriber
        ];
    }

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->disableReboot();

        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function createUserAndGetJsonToken(): array
    {
        // Create User
        $user = new User();
        $user->setName('test');
        $user->setLastName('test');
        $user->setEmail('test@example.com');
        $user->setPassword(
            $this->client->getContainer()->get('security.user_password_hasher')->hashPassword($user, 'passw')
        );
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Get token
        $response = $this->client->request('POST', '/api/authentication_token', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'test@example.com',
                'password' => 'passw',
            ],
        ]);
        return $response->toArray();
    }

    // public function testGetCollection(): void
    // {
    //     $response = static::createClient()->request('GET', '/api/missions');
    //     $this->assertResponseIsSuccessful();
    // }

    public function testCreateMission(): void
    {
        $json = $this->createUserAndGetJsonToken();
        $this->assertArrayHasKey('token', $json);

        // Create Mission
        $this->client->request('POST', '/api/missions', [
            'auth_bearer' => $json['token'],
            'json' => $this->getData()
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'title' => 'Mission Test',
            'description' => 'Mission Description Test'
        ]);
        $this->assertMatchesResourceItemJsonSchema(Mission::class);
    }

    public function testCreateInvalidMission(): void
    {
        $json = $this->createUserAndGetJsonToken();
        $this->assertArrayHasKey('token', $json);

        $this->client->request('POST', '/api/missions', [
            'auth_bearer' => $json['token'],
            'json' => [
                'title' => 'Missions Test',
            ]
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testUpdateMission(): void
    {
        $json = $this->createUserAndGetJsonToken();
        $this->assertArrayHasKey('token', $json);

        $this->client->request('POST', '/api/missions', [
            'auth_bearer' => $json['token'],
            'json' => $this->getData()
        ]);

        $mission = $this->entityManager->getRepository(Mission::class)->findOneBy(['title' => 'Mission Test']);
        $this->assertInstanceOf(Mission::class, $mission);

        $this->client->request('PATCH', '/api/missions/' . $mission->getId(), [
            'json' => [
                'title' => 'updated title',
            ],
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'title' => 'updated title',
        ]);
    }

    public function testDeleteMission(): void
    {
        $json = $this->createUserAndGetJsonToken();
        $this->assertArrayHasKey('token', $json);

        $this->client->request('POST', '/api/missions', [
            'auth_bearer' => $json['token'],
            'json' => $this->getData()
        ]);

        $mission = $this->entityManager->getRepository(Mission::class)->findOneBy(['title' => 'Mission Test']);

        $this->client->request('DELETE', '/api/missions/' . $mission->getId());

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            $this->entityManager->getRepository(Mission::class)->findOneBy(['title' => 'Mission Test'])
        );
    }
}