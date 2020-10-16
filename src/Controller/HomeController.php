<?php

namespace App\Controller;

use App\Form\PostCreateFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $form = $this->createForm(PostCreateFormType::class);
        $form->handleRequest($request);

        return $this->render('home/index.html.twig', [
            'createPostForm' => $form->createView()
        ]);
    }
}
