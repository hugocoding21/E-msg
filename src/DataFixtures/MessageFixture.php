<?php

namespace App\DataFixtures;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixture extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 2; $i++) {
            $message = new Message();
            /**
             * @var User $user
             */
            $user = $this->getReference('user-'.$i);
            $message->setSendBy($user);
            $message->setSendAt(new \DateTime());
            $message->setRead(false);
            $message->setReadAt(new \DateTime());
            /**
             * @var Conversation $conversation
             */
            $conversation= $this->getReference('conversation-'.$i);
            $message->setConversation($conversation);
            $message->setContent('Message ' . $i);
            $manager->persist($message);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            ConversationFixture::class
        ];
    }
}
