<?php

namespace App\Web\Post;

use App\Core\Post\PostServiceInterface;
use App\Core\Time\TimeServiceInterface;
use App\Web\Post\Create\PostCreateFormType;
use App\Web\Post\Create\PostCreateSubmission;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PostController extends AbstractController
{
    /**
     * @Route("/posts", name="posts")
     *
     * Lists all posts and provides a form for creating new posts.
     *
     * @param Request $request
     * @param PostServiceInterface $postService
     * @param Security $security
     * @param TimeServiceInterface $timeService
     *
     * @return Response
     */
    public function listPosts(
        Request $request,
        PostServiceInterface $postService,
        Security $security,
        TimeServiceInterface $timeService
    ): Response
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
        return $this->render('posts/list.html.twig', [
            'createPostForm' => $createForm->createView(),
            'currentUser' => $security->getUser(),
            'posts' => $posts,
            'timeService' => $timeService
        ]);
    }

    /**
     * @Route("/posts/{id}", name="post_detail")
     *
     * @param Request $request
     * @param PostServiceInterface $postService
     * @param Security $security
     * @param TimeServiceInterface $timeService
     *
     * @return Response
     */
    public function getPost(
        Request $request,
        PostServiceInterface $postService,
        Security $security,
        TimeServiceInterface $timeService
    ): Response
    {
        // get post
        $post = $postService->get($request->get('id'));
        if ($post === null) { // no post exists with the uuid
            throw new NotFoundHttpException();
        }

        // wrap paragraphs in <p> tags
        $paragraphs = array_filter(explode("\n", $post->getText()));
        $text = '';
        foreach ($paragraphs as $paragraph) {
            $text .= '<p>' . htmlentities($paragraph) . '</p>';
        }

        // render post page
        return $this->render('posts/get.html.twig', [
            'currentUser' => $security->getUser(),
            'post' => $post,
            'postText' => $text,
            'timeService' => $timeService
        ]);
    }
}
