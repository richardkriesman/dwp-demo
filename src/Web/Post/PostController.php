<?php

namespace App\Web\Post;

use App\Web\Post\Create\PostCreateFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/posts", name="posts")
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $form = $this->createForm(PostCreateFormType::class);
        $form->handleRequest($request);

        // handle create post form
        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('posts/index.html.twig', [
            'createPostForm' => $form->createView()
        ]);
    }
}
