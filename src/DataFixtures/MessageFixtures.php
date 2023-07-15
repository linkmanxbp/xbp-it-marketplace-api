<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\MessageUser;
use App\Entity\Response;
use App\Entity\ResponseUser;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    private ObjectManager $manager;

    private function getData(): array
    {
        return [
            ['response' => 1, 'user' => 3, 'content' => 'Hello, are you interested in my profile (id:8) ?'],
            ['response' => 1, 'user' => 2, 'content' => 'Yes, sure ! The profile (id:8) could correspond to my mission (id:1)']
        ];
    }

    public function getDependencies()
    {
        return [ResponseFixtures::class];
    }

    private function postMessage(
        Response $response,
        User $sender,
        User $recipient,
        string $content
    ) {
        $message = new Message();
        $message->setResponse($response);
        $message->setUser($sender);
        $message->setContent($content);
        $this->manager->persist($message);

        $messageUser = new MessageUser();
        $messageUser->setMessage($message);
        $messageUser->setUser($sender);
        $this->manager->persist($messageUser);

        $messageUser = new MessageUser();
        $messageUser->setMessage($message);
        $messageUser->setUser($recipient);
        $this->manager->persist($messageUser);
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $messages = $this->getData();

        // responseUser
        $responseUserOne = $manager->getRepository(ResponseUser::class)->findOneBy([
            'response' => $messages[0]['response'],
            'user' => $messages[0]['user']
        ]);
        $responseUserTwo = $manager->getRepository(ResponseUser::class)->findOneBy([
            'response' => $messages[1]['response'],
            'user' => $messages[1]['user']
        ]);

        // Message 1
        $this->postMessage(
            $responseUserOne->getResponse(),
            $responseUserOne->getUser(),
            $responseUserTwo->getUser(),
            $messages[0]['content']
        );

        // Message 2
        $this->postMessage(
            $responseUserTwo->getResponse(),
            $responseUserTwo->getUser(),
            $responseUserOne->getUser(),
            $messages[1]['content']            
        );

        $manager->flush();
    }
}