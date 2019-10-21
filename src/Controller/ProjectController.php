<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\{TextareaType, FileType};
use App\Entity\Tricks;
use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project/allTricks", name="all_tricks")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        
        $articles = $repo->findAll();

        return $this->render('project/allTriks.html.twig', [
            'controller_name' => 'ProjectController',
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home() 
    {
        return $this->render('project/home.html.twig');
    } 
    /**
     * @Route("/project/newTricks", name="new_tricks")
     */
    public function newTricks(Request $request, ObjectManager $manager) {
        $trick = new Tricks();
        $form = $this->createFormBuilder($trick)
                     ->add('Tricks_name')
                     ->add('Tricks_description', TextareaType::class)
                     ->add('Tricks_illustration', FileType::class)
                     ->getForm();
    
        return $this->render('project/newTricks.html.twig', [
            'formTricks' => $form->createView()
        ]);
    }

    /**
     * @route("/project/{id}", name="blog_show")
     */
    public function show(Article $article)
    {
        return $this->render('project/show.html.twig', [
            'article' => $article
            ]);
    }
    
}