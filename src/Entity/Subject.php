<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubjectRepository::class)
 */
class Subject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=Course::class, mappedBy="subject")
     */
    private $courses;

    /**
     * @ORM\ManyToMany(targetEntity=Subject::class, inversedBy="subjects")
     */
    private $subject;

    /**
     * @ORM\ManyToMany(targetEntity=Subject::class, mappedBy="subject")
     */
    private $subjects;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->subject = new ArrayCollection();
        $this->subjects = new ArrayCollection();
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

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->addSubject($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            $course->removeSubject($this);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubject(): Collection
    {
        return $this->subject;
    }

    public function addSubject(self $subject): self
    {
        if (!$this->subject->contains($subject)) {
            $this->subject[] = $subject;
        }

        return $this;
    }

    public function removeSubject(self $subject): self
    {
        $this->subject->removeElement($subject);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }
}
