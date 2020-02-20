<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PdiRepository")
 */
class Pdi
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
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_depot;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_batiment;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_boites;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_reex;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tournee", inversedBy="pdis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournee_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Libelle", inversedBy="pdis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $libelle_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->client_name;
    }

    public function setClientName(string $client_name): self
    {
        $this->client_name = $client_name;

        return $this;
    }

    public function getIsDepot(): ?bool
    {
        return $this->is_depot;
    }

    public function setIsDepot(bool $is_depot): self
    {
        $this->is_depot = $is_depot;

        return $this;
    }

    public function getIsBatiment(): ?bool
    {
        return $this->is_batiment;
    }

    public function setIsBatiment(bool $is_batiment): self
    {
        $this->is_batiment = $is_batiment;

        return $this;
    }

    public function getNbBoites(): ?int
    {
        return $this->nb_boites;
    }

    public function setNbBoites(int $nb_boites): self
    {
        $this->nb_boites = $nb_boites;

        return $this;
    }

    public function getIsReex(): ?bool
    {
        return $this->is_reex;
    }

    public function setIsReex(bool $is_reex): self
    {
        $this->is_reex = $is_reex;

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

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function getTourneeId(): ?Tournee
    {
        return $this->tournee_id;
    }

    public function setTourneeId(?Tournee $tournee_id): self
    {
        $this->tournee_id = $tournee_id;

        return $this;
    }

    public function getLibelleId(): ?Libelle
    {
        return $this->libelle_id;
    }

    public function setLibelleId(?Libelle $libelle_id): self
    {
        $this->libelle_id = $libelle_id;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }
}
