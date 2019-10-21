<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TricksRepository")
 */
class Tricks
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Tricks_name;

    /**
     * @ORM\Column(type="text")
     */
    private $Tricks_Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Tricks_illustration;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTricksName(): ?string
    {
        return $this->Tricks_name;
    }

    public function setTricksName(string $Tricks_name): self
    {
        $this->Tricks_name = $Tricks_name;

        return $this;
    }

    public function getTricksDescription(): ?string
    {
        return $this->Tricks_Description;
    }

    public function setTricksDescription(string $Tricks_Description): self
    {
        $this->Tricks_Description = $Tricks_Description;

        return $this;
    }

    public function getTricksIllustration(): ?string
    {
        return $this->Tricks_illustration;
    }

    public function setTricksIllustration(string $Tricks_illustration): self
    {
        $this->Tricks_illustration = $Tricks_illustration;

        return $this;
    }
}
