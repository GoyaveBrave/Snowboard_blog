<?php


namespace App\DTO;


class CreateTrickDTO
{

    public $name;
    public $description;
    public $illustrationFileName;

    /**
     * CreateTrickDTO constructor.
     * @param $name
     * @param $description
     * @param $illustrationFileName
     */
    public function __construct($name, $description, $illustrationFileName)
    {
        $this->name = $name;
        $this->description = $description;
        $this->illustrationFileName = $illustrationFileName;
    }

}