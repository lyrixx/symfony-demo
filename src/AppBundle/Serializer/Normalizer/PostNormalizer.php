<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Post;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PostNormalizer implements NormalizerInterface
{
    private $normalizer;
    private $router;

    public function __construct(ObjectNormalizer $normalizer, RouterInterface $router)
    {
        $this->normalizer = $normalizer;
        $this->router = $router;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Post;
    }

    public function normalize($post, $format = null, array $context = array())
    {
        $data = $this->normalizer->normalize($post, $format, $context);

        // Deal with circular ref
        if (!is_array($data)) {
            return $data;
        }

        $data['url'] =  $this->router->generate('api_blog_show', ['id' => $post->getId()], RouterInterface::ABSOLUTE_URL);

        if (isset($context['groups']) && in_array('post_read', $context['groups'])) {
            $data['nb_comments'] = $post->getComments()->count();
        }

        return $data;
    }
}
