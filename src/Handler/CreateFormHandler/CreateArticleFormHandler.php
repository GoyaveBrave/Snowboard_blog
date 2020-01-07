<?php


namespace App\Handler\CreateFormHandler;

use App\Builder\CreateArticleBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class CreateArticleFormHandler implements CreateArticleFormHandlerInterface
{
    private $article;
    /**
     * @var CreateArticleBuilder
     */
    private $createArticleBuilder;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CreateArticleFormHandler constructor.
     * @param CreateArticleBuilder $createArticleBuilder
     * @param EntityManagerInterface $em
     */
    public function __construct(CreateArticleBuilder $createArticleBuilder, EntityManagerInterface $em)
    {
        $this->createArticleBuilder = $createArticleBuilder;
        $this->em = $em;
    }


    public function handle(FormInterface $form): bool
    {
        if($form->isSubmitted() && $form->isValid()) {
            $dto = $form->getData();
            $this->createArticleBuilder->build($dto);
            $this->article = $this->createArticleBuilder->getArticle();

            $this->em->persist($this->article);
            $this->em->flush();
            //dd($this->article);
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

}