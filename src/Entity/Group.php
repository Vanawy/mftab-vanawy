<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 */
class Group
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Course", inversedBy="groups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pair", mappedBy="linkedGroup", orphanRemoval=true)
     */
    private $pairs;

    public function __construct()
    {
        $this->pairs = new ArrayCollection();
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

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }


    /**
     * @return Collection|Pair[]
     */
    public function getPairs(): Collection
    {
        return $this->pairs;
    }

    public function addPair(Pair $pair): self
    {
        if (!$this->pairs->contains($pair)) {
            $this->pairs[] = $pair;
            $pair->setLinkedGroup($this);
        }

        return $this;
    }

    public function removePair(Pair $pair): self
    {
        if ($this->pairs->contains($pair)) {
            $this->pairs->removeElement($pair);
            // set the owning side to null (unless already changed)
            if ($pair->getLinkedGroup() === $this) {
                $pair->setLinkedGroup(null);
            }
        }

        return $this;
    }
}
