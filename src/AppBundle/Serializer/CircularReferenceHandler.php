<?php

namespace AppBundle\Serializer;

use AppBundle\Entity\Post;
use Symfony\Component\Routing\RouterInterface;

class CircularReferenceHandler
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function __invoke($object)
    {
        if ($object instanceof Post) {
            return $this->router->generate('api_blog_show', ['id' => $object->getId()], RouterInterface::ABSOLUTE_URL);
        }
    }
}
