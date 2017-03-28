<?php

namespace AppBundle\Workflow;

use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;

class BitMarkingStore implements MarkingStoreInterface
{
    const IS_NEW = 1;
    const ACCEPTED = 2;
    const PUBLISHED = 4;

    public function getMarking($post)
    {
        $places = [];
        $bitField = $post->getStatus();

        if ($bitField & self::IS_NEW) {
            $places['new'] = 1;
        }

        if ($bitField & self::ACCEPTED) {
            $places['accepted'] = 1;
        }

        if ($bitField & self::PUBLISHED) {
            $places['published'] = 1;
        }

        return new Marking($places);
    }

    public function setMarking($post, Marking $marking)
    {
        $bitField = 0;

        if ($marking->has('new')) {
            $bitField |= self::IS_NEW;
        }

        if ($marking->has('accepted')) {
            $bitField |= self::ACCEPTED;
        }

        if ($marking->has('published')) {
            $bitField |= self::PUBLISHED;
        }

        $post->setStatus($bitField);
    }
}
