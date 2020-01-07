<?php


namespace App\Builder;


use App\DTO\CreateArticleDTO;
use App\Entity\Article;

//Class qui sert à créer l'article via DTO
class CreateArticleBuilder
{

    private $article;

    public function build(CreateArticleDTO $createArticleDTO)
    {
        $this->article = new Article($createArticleDTO->title, $createArticleDTO->content);
    }

    public function getArticle()
    {
        return $this->article;
    }
}