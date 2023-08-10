<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\Mission;
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
            'user' => '/api/users/2'
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

    // public function testGetCollection(): void
    // {
    //     $response = static::createClient()->request('GET', '/api/missions');
    //     $this->assertResponseIsSuccessful();
    // }

    public function testCreateMission(): void
    {
        $this->client->request('POST', '/api/missions', [
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
        $this->client->request('POST', '/api/missions', [
            'json' => [
                'title' => 'Missions Test',
            ]
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testUpdateMission(): void
    {
        $this->client->request('POST', '/api/missions', [
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
        $this->client->request('POST', '/api/missions', [
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