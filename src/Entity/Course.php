<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Service\AppService;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Shedule", inversedBy="courses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shedule;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="course", cascade={"persist", "remove"})
     */
    private $groups;


    /**
     * @ORM\Column(type="array")
     */
    private $times;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;   

    public function getTimes(): ?array
    {
        return $this->times;
    }

    public function setTimes(array $times): self
    {
        $this->times = $times;

        return $this;
    }

    public function __construct()
    {
        $this->groups = new ArrayCollection();
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

        $as = new AppService();
        $this->setUrl($as->url($name));

        return $this;
    }

    public function getShedule(): ?Shedule
    {
        return $this->shedule;
    }

    public function setShedule(?Shedule $shedule): self
    {
        $this->shedule = $shedule;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->setCourse($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            // set the owning side to null (unless already changed)
            if ($group->getCourse() === $this) {
                $group->setCourse(null);
            }
        }

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
