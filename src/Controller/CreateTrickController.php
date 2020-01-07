<?php


namespace App\Controller;



use App\Form\TrickType;
use App\Handler\CreateFormHandler\CreateTrickFormHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CreateTrickController
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
     * CreateTrickController constructor.
     * @param FormFactoryInterface $formFactory
     * @param Environment $twig

     */
    public function __construct(FormFactoryInterface $formFactory, Environment $twig)
    {
        $this->formFactory = $formFactory;
        $this->twig = $twig;

    }

    /**
     * @Route("/create/trick", name="create_trick")
     * @param Request $request
     * @param CreateTrickFormHandlerInterface $formHandler
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request, CreateTrickFormHandlerInterface $formHandler)
    {
        $form = $this->formFactory->create(TrickType::class)->handleRequest($request);
        if ($formHandler->handle($form)) {
            dd($trick = $formHandler->getTrick());
        }
        $response = new Response();
        return $response->setContent($this->twig->render('create_trick/createTrick.html.twig', [
            'formTricks' => $form->createView(),
            ]));
    }


}