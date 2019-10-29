<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\{TextareaType, FileType, SubmitType, TextType};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProjectController extends AbstractController
{
    /**
     * @Route("/project/allTricks", name="all_tricks")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Tricks::class);
        
        $tricks = $repo->findAll();

        return $this->render('project/allTriks.html.twig', [
            'controller_name' => 'ProjectController',
            'tricks' => $tricks
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
     * @Route("/project/{id}/edit", name="tricks_edit")
     */
    public function form(Tricks $trick = null, Request $request, ObjectManager $manager) {
        if(!$trick) {
            $trick = new Tricks();
        }

        $form = $this->createForm(TrickType::class,$trick);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form['illustration']->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $trick->setillustrationFilename($newFilename);
            }
            $manager->persist($trick);
            $manager->flush();
            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);
        }

        return $this->render('project/newTricks.html.twig', [
            'formTricks' => $form->createView(),
            'editMode' => $trick->getId() !== null
        ]);
    }

    /**
     * @route("/project/{id}", name="trick_show")
     */
    public function show(Tricks $trick, Request $request, ObjectManager $manager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setTrick($trick);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);
        }
        return $this->render('project/show.html.twig', [
            'trick' => $trick,
            'commentForm' => $form->createView()
            ]);
    }
    
}