<?php


namespace App\DTO;


//1->Objet volatile qui contient les données du form
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CreateArticleDTO
{
    public $title;
    public $content;

    /**
     * CreateArticleDTO constructor.
     * @param $title
     * @param $content
     */
    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }
}