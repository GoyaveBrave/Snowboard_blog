<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Tricks;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Form\PictureType;
use Doctrine\ORM\EntityManager;
use App\Entity\PictureIllustration;
use App\Repository\PictureIllustrationRepository;
use App\Repository\TricksRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\{TextareaType, FileType, SubmitType, TextType};

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
    public function home(TricksRepository $repository, Request $request, PaginatorInterface $paginator) 
    {
        $q = $request->query->get('q');
        $queryBuilder = $repository->getWithSearchQueryBuilder($q);
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        $repo = $this->getDoctrine()->getRepository(Tricks::class);
        
        $tricks = $repo->findAll();

        return $this->render('project/home.html.twig', [
            'controller_name' => 'ProjectController',
            'pagination' => $pagination,
            'tricks' => $tricks
        ]);
    } 
    /**
     * @Route("/project/newTricks", name="new_tricks")
     * @Route("/project/edit/{id}", name="tricks_edit")
     */
    public function form (Tricks $trick = null, PictureIllustration $picture = null, Request $request, ObjectManager $manager) {



            $pictureCollection = new ArrayCollection();

            foreach ($trick->getPictureIllustration() as $picture) {
                $pictureCollection->add($picture);
            }

            $form = $this->createForm(TrickType::class, $trick);
            $form->handleRequest($request);

        
            if($form->isSubmitted() && $form->isValid()) {
            $firstFile = $form['illustrationFilename']->getData();
            $secondeFile = $form['pictureIllustration']->getData();
            
            //PREMIER IMG
            if ($firstFile) {
                $originalFilename = pathinfo($firstFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$firstFile->guessExtension();
                try {
                    $firstFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $trick->setIllustrationFilename($newFilename);
            }

            foreach ($secondeFile as $mediaImage) {
                $picture->setTricks($trick);
                $manager->persist($mediaImage);
            }
            
            $manager->persist($trick);
            $manager->flush();
    
            $this->addFlash(
                'notice',
                'Your changes were saved!');

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId(), 'slug' => $trick->getSlug()]);
        }

        return $this->render('project/newTricks.html.twig', [
            'formTricks' => $form->createView(),            
            'editMode' => $trick->getId() !== null
        ]);
    }

    /**
     * @route("/project/{id}/{slug}", name="trick_show")
     */
    public function show(Tricks $trick, Request $request, ObjectManager $manager, PictureIllustrationRepository $repo)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setTrick($trick);

            $manager->persist($comment);
            $manager->flush();
            
            return $this->redirectToRoute('trick_show', ['id' => $trick->getId(), 'slug' => $trick->getSlug()]);
        }

        $pictureIllustration = $repo->findBy(array('tricks' => $trick->getId()));

        return $this->render('project/show.html.twig', [
            'trick' => $trick,
            'pictureIllustrations' => $pictureIllustration,
            'commentForm' => $form->createView()
            ]);
    }

    /**
     * @Route("project/gallerie", name="app_gallery")
     */
    public function gallery(PictureIllustration $picture = null, Request $request, ObjectManager $manager)
    {
        //Show my gallery
        $repo = $this->getDoctrine()->getRepository(PictureIllustration::class);
        $pictures = $repo->findAll();

        //Form view
        $picture = new PictureIllustration();
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        //Form submit & Validation 
        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form['picture']->getData();

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
                $picture->setPicture($newFilename);
            }
            $manager->persist($picture);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!');

            return $this->redirectToRoute('app_gallery');
        }

        

        return $this->render('project/gallery.html.twig',[
            'pictures' => $pictures,
            'formPictures' => $form->createView()
        ]);
    }



    /**
     * @Route("project/delete/{id}/{slug}", name="delete")
     */
    public function delete(Tricks $trick, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $trick = $entityManager->getRepository(Tricks::class)->find($id);
        $entityManager->remove($trick);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
    
}