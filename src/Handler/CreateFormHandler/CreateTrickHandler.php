<?php


namespace App\Handler\CreateFormHandler;


use App\Builder\CreateTrickBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class CreateTrickHandler implements CreateTrickFormHandlerInterface
{
    private $trick;
    /**
     * @var CreateTrickBuilder
     */
    private $createTrickBuilder;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CreateTrickHandler constructor.
     * @param CreateTrickBuilder $createTrickBuilder
     * @param EntityManagerInterface $em
     */
    public function __construct(CreateTrickBuilder $createTrickBuilder, EntityManagerInterface $em)
    {
        $this->createTrickBuilder = $createTrickBuilder;
        $this->em = $em;
    }
    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $dto = $form->getData();
            //dd($dto);
            $this->createTrickBuilder->build($dto);
            $this->trick = $this->createTrickBuilder->getTrick();

            $this->em->persist($this->trick);
            $this->em->flush();

            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getTrick()
    {
        return $this->trick;
    }
}