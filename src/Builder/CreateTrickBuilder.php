<?php


namespace App\Builder;


use App\DTO\CreateTrickDTO;
use App\Entity\Tricks;

class CreateTrickBuilder
{
    private $trick;

    public function build(CreateTrickDTO $createTrickDTO)
    {
        $this->trick = new Tricks($createTrickDTO->name, $createTrickDTO->description, $createTrickDTO->illustrationFileName);
    }

    /**
     * @return mixed
     */
    public function getTrick()
    {
        return $this->trick;
    }

}