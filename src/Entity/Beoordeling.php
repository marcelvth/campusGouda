<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BeoordelingRepository")
 */
class Beoordeling
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="beoordelings")
     */
    private $student_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $beschrijving;

    /**
     * @ORM\Column(type="integer")
     */
    private $starRating;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudentId(): ?Student
    {
        return $this->student_id;
    }

    public function setStudentId(?Student $student_id): self
    {
        $this->student_id = $student_id;

        return $this;
    }

    public function getBeschrijving(): ?string
    {
        return $this->beschrijving;
    }

    public function setBeschrijving(?string $beschrijving): self
    {
        $this->beschrijving = $beschrijving;

        return $this;
    }

    public function getStarRating(): ?int
    {
        return $this->starRating;
    }

    public function setStarRating(int $starRating): self
    {
        $this->starRating = $starRating;

        return $this;
    }

    public function __toString()
    {
       return $this-> id. '->' . $this ->student_id;
    }
}
