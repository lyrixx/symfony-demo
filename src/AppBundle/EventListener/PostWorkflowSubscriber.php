<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class PostWorkflowSubscriber implements EventSubscriberInterface
{
    public function setPublishedAt(Event $event)
    {
        $post = $event->getSubject();

        if (!$post->getPublishedAt()) {
            $post->setPublishedAt(new \DateTime());
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.post.transition.publish' => 'setPublishedAt',
        ];
    }
}
