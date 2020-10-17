<?php

namespace App\Web\Post;

use App\Core\Post\PostServiceInterface;
use App\Core\Time\TimeServiceInterface;
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
     * @param TimeServiceInterface $timeService
     *
     * @return Response
     */
    public function index(
        Request $request,
        PostServiceInterface $postService,
        Security $security,
        TimeServiceInterface $timeService
    )
    {
        $createSubmission = new PostCreateSubmission();
        $createForm = $this->createForm(PostCreateFormType::class, $createSubmission);
        $createForm->handleRequest($request);

        // handle create post form
        if ($createForm->isSubmitted() && $createForm->isValid()) {

            // create a new post
            $postService->create($createSubmission->title, $createSubmission->text, $security->getUser());

            // clear form values
            $createSubmission = new PostCreateSubmission();
            $createForm = $this->createForm(PostCreateFormType::class, $createSubmission);
        }

        // get all posts
        // in a real project we'd want to do some database-side pagination here
        $posts = $postService->getAll();

        // render page
        return $this->render('posts/index.html.twig', [
            'createPostForm' => $createForm->createView(),
            'currentUser' => $security->getUser(),
            'posts' => $posts,
            'timeService' => $timeService
        ]);
    }
}
