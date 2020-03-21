<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PdiRepository")
 */
class Pdi
{

    public function __construct(){
        $this->client_name = "";
        $this->format = '1x1';
        $this->is_depot = false;
        $this->is_reex = false;
        $this->libelle_id = new Libelle();
    }
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Libelle", inversedBy="pdis", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $libelle_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $format;

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

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }
}
