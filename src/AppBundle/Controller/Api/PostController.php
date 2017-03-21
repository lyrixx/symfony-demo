<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/posts")
 * @Method("GET")
 */
class PostController extends Controller
{
    /**
     * @Route("", name="api_blog_index")
     */
    public function indexAction(Request $request)
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findLatest($request->query->getInt('page', 1));

        $repr = $this->get('serializer')->serialize($posts, 'json', ['groups' => ['post_list_read']]);

        return JsonResponse::fromJsonString($repr);
    }

    /**
     * @Route("/{id}", name="api_blog_show")
     */
    public function showAction(Post $post)
    {
        $repr = $this->get('serializer')->serialize($post, 'json', ['groups' => ['post_read']]);

        return JsonResponse::fromJsonString($repr);
    }
}
