<?php

namespace App\Controller;

use App\Form\ArticleType;
use App\Handler\CreateFormHandler\CreateArticleFormHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

//
class CreateArticleController
{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var Environment
     */
    private $twig;


    /**
     * CreateArticleController constructor.
     * @param FormFactoryInterface $formFactory
     * @param Environment $twig

     */
    public function __construct(FormFactoryInterface $formFactory,
                                Environment $twig
                                )
    {

        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    /**
     * @Route("/create/article", name="create_article")
     * @param Request $request
     * @param CreateArticleFormHandlerInterface $formHandler
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(Request $request, CreateArticleFormHandlerInterface $formHandler)
    {
        $form = $this->formFactory->create(ArticleType::class)->handleRequest($request);

        if ($formHandler->handle($form)){

            //$this->redirection->redirect(new RedirectResponse(''))
            dd($article = $formHandler->getArticle());
        }
        $response = new Response();
        return $response->setContent($this->twig->render('create_article/index.html.twig', [
            'createArticleForm' => $form->createView(),
        ]));
    }
}
