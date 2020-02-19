<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
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
    private $naam;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $woonplaats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Beoordeling", mappedBy="student_id")
     */
    private $beoordelings;

    public function __construct()
    {
        $this->beoordelings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdres(): ?string
    {
        return $this->adres;
    }

    public function setAdres(string $adres): self
    {
        $this->adres = $adres;

        return $this;
    }

    public function getWoonplaats(): ?string
    {
        return $this->woonplaats;
    }

    public function setWoonplaats(string $woonplaats): self
    {
        $this->woonplaats = $woonplaats;

        return $this;
    }

    /**
     * @return Collection|Beoordeling[]
     */
    public function getBeoordelings(): Collection
    {
        return $this->beoordelings;
    }

    public function addBeoordeling(Beoordeling $beoordeling): self
    {
        if (!$this->beoordelings->contains($beoordeling)) {
            $this->beoordelings[] = $beoordeling;
            $beoordeling->setStudentId($this);
        }

        return $this;
    }

    public function removeBeoordeling(Beoordeling $beoordeling): self
    {
        if ($this->beoordelings->contains($beoordeling)) {
            $this->beoordelings->removeElement($beoordeling);
            // set the owning side to null (unless already changed)
            if ($beoordeling->getStudentId() === $this) {
                $beoordeling->setStudentId(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this-> id. 'is student' . $this ->naam;
    }
}
