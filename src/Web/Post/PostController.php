<?php

namespace App\Web\Post;

use App\Core\Post\PostServiceInterface;
use App\Core\Time\TimeServiceInterface;
use App\Web\Post\Form\PostFormType;
use App\Web\Post\Form\PostSubmission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PostController extends AbstractController
{
    /**
     * @Route("/posts", name="post_list")
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
        // create post form
        $submission = new PostSubmission();
        $form = $this->createForm(PostFormType::class, $submission);
        $form->handleRequest($request);

        // handle form submission
        if ($form->isSubmitted() && $form->isValid()) {

            // create a new post
            $postService->create($submission->title, $submission->text, $security->getUser());

            // clear form values
            $submission = new PostSubmission();
            $form = $this->createForm(PostFormType::class, $submission);
        }

        // get all posts
        // in a real project we'd want to do some database-side pagination here
        $posts = $postService->getAll();

        // render page
        return $this->render('posts/list.html.twig', [
            'currentUser' => $security->getUser(),
            'form' => $form->createView(),
            'posts' => $posts,
            'timeService' => $timeService
        ]);
    }

    /**
     * @Route("/posts/{id}", name="post_view")
     *
     * @param Request $request
     * @param PostServiceInterface $postService
     * @param Security $security
     * @param TimeServiceInterface $timeService
     *
     * @return Response
     */
    public function viewPost(
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

        // render page
        return $this->render('posts/get.html.twig', [
            'currentUser' => $security->getUser(),
            'post' => $post,
            'postText' => $text,
            'timeService' => $timeService
        ]);
    }

    /**
     * @Route("/posts/{id}/edit", name="post_edit")
     *
     * @param Request $request
     * @param PostServiceInterface $postService
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function editPost(
        Request $request,
        PostServiceInterface $postService,
        Security $security,
        EntityManagerInterface $entityManager
    ): Response
    {
        // get post
        $post = $postService->get($request->get('id'));
        if ($post === null) { // no post exists with the uuid
            throw new NotFoundHttpException();
        }
        if ($post->getUser() !== $security->getUser()) { // user is not the author, don't allow them to edit this post
            return $this->redirectToRoute('post_list');
        }

        // create post form
        $submission = new PostSubmission();
        $submission->title = $post->getTitle();
        $submission->text = $post->getText();
        $form = $this->createForm(PostFormType::class, $submission);
        $form->handleRequest($request);

        // handle form submission
        if ($form->isSubmitted() && $form->isValid()) {

            // modify the post title and text - it'd probably be better to do this as an event, tbh
            $post->setTitle($submission->title);
            $post->setText($submission->text);
            $entityManager->flush();

            // redirect the user to their edited post
            return $this->redirectToRoute('post_view', [
                'id' => $post->getId()
            ]);
        }

        // render page
        return $this->render('posts/edit.html.twig', [
            'currentUser' => $security->getUser(),
            'form' => $form->createView(),
            'post' => $post
        ]);
    }
}
