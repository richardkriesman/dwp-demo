<?php

namespace App\Web\Post;

use App\Core\Post\PostServiceInterface;
use App\Web\Post\Create\PostCreateFormType;
use App\Web\Post\Create\PostCreateSubmission;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PostController extends AbstractController
{
    /**
     * @Route("/posts", name="posts")
     *
     * @param Request $request
     * @param PostServiceInterface $postService
     * @param Security $security
     *
     * @return Response
     */
    public function index(Request $request, PostServiceInterface $postService, Security $security)
    {
        $createSubmission = new PostCreateSubmission();
        $createForm = $this->createForm(PostCreateFormType::class, $createSubmission);
        $createForm->handleRequest($request);

        // handle create post form
        if ($createForm->isSubmitted() && $createForm->isValid()) {

            // create a new post
            $postService->create($createSubmission->text, $security->getUser());

            // clear form values
            $createSubmission = new PostCreateSubmission();
            $createForm = $this->createForm(PostCreateFormType::class, $createSubmission);
        }

        // render page
        return $this->render('posts/index.html.twig', [
            'createPostForm' => $createForm->createView()
        ]);
    }
}
