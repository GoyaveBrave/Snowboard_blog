<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TricksRepository")
 * @UniqueEntity(
 *      fields={"name"},
 *      message="Trick déjà crée!" )
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $illustrationFilename;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="tricks")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=700, nullable=true)
     */
    private $videoIllustration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PictureIllustration", mappedBy="tricks", cascade={"persist"})
     */
    private $pictureIllustration;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->pictureIllustration = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        $this->setSlug($this->name);

        return $this;
    }

    public function getdescription(): ?string
    {
        return $this->description;
    }

    public function setdescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getillustrationFilename(): ?string
    {
        return $this->illustrationFilename;
    }

    public function setillustrationFilename(string $illustrationFilename): self
    {
        $this->illustrationFilename = $illustrationFilename;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    public function getVideoIllustration(): ?string
    {
        return $this->videoIllustration;
    }

    public function setVideoIllustration(?string $videoIllustration): self
    {
        $this->videoIllustration = $videoIllustration;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function slugify($text)
    {
        $text = str_replace(" ","-",$text);
        // replace non letter or digits by -
    $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    if (function_exists('iconv'))
    {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('#[^-\w]+#', '', $text);

    if (empty($text))
    {
        return 'n-a';
    }

    return urldecode($text);
    }

    /**
     * @return Collection|PictureIllustration[]
     */
    public function getPictureIllustration(): Collection
    {
        return $this->pictureIllustration;
    }

    public function addPictureIllustration(PictureIllustration $pictureIllustration): self
    {
        if (!$this->pictureIllustration->contains($pictureIllustration)) {
            $this->pictureIllustration[] = $pictureIllustration;
            $pictureIllustration->setTricks($this);
        }

        return $this;
    }

    public function removePictureIllustration(PictureIllustration $pictureIllustration): self
    {
        if ($this->pictureIllustration->contains($pictureIllustration)) {
            $this->pictureIllustration->removeElement($pictureIllustration);
            // set the owning side to null (unless already changed)
            if ($pictureIllustration->getTricks() === $this) {
                $pictureIllustration->setTricks(null);
            }
        }

        return $this;
    }

    public function addTricks(Tricks $tricks)
    {
        $this->tricks->add($tricks);
    }

    public function removeTricks(Tricks $tricks)
    {
        $this->tricks->removeElement($tricks);
    }

    
}
