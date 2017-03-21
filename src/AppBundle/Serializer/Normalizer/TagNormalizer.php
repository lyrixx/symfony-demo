<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TagNormalizer implements NormalizerInterface, DenormalizerInterface
{
    private $tagRepository;

    public function __construct(EntityRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function normalize($tag, $format = null, array $context = array())
    {
        return [
            'name' => $tag->getName(),
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Tag;
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $tag = $this->tagRepository->findOneBy(['name' => $data['name']]);

        if ($tag) {
            return $tag;
        }

        $tag = new Tag();
        $tag->setName($data['name']);

        return $tag;

    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return 'AppBundle\Entity\Tag' === $type;
    }
}
