<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LibelleRepository")
 */
class Libelle
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pdi", mappedBy="libelle_id")
     */
    private $pdis;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="libelles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ville_id;

    public function __construct()
    {
        $this->pdis = new ArrayCollection();
        $this->name = "";
        $this->ville_id = new Ville();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Pdi[]
     */
    public function getPdis(): Collection
    {
        return $this->pdis;
    }

    public function addPdi(Pdi $pdi): self
    {
        if (!$this->pdis->contains($pdi)) {
            $this->pdis[] = $pdi;
            $pdi->setLibelleId($this);
        }

        return $this;
    }

    public function removePdi(Pdi $pdi): self
    {
        if ($this->pdis->contains($pdi)) {
            $this->pdis->removeElement($pdi);
            // set the owning side to null (unless already changed)
            if ($pdi->getLibelleId() === $this) {
                $pdi->setLibelleId(null);
            }
        }

        return $this;
    }

    public function getVilleId(): ?Ville
    {
        return $this->ville_id;
    }

    public function setVilleId(?Ville $ville_id): self
    {
        $this->ville_id = $ville_id;

        return $this;
    }

    public function __toString(){
        return $this->name ? $this->name : "";
    }
}
