<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(min: '2', max: 55, minMessage: "Le titre doit faire au moins {{ limit }} caractères, {{ value }} est trop court", maxMessage: 'Le titre doit faire au maximum {{ limit }} caractères')]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    #[ORM\Column(length: 200)]
    private ?string $titre = null;

    #[Assert\Length(min: '2', max: 55, minMessage: "La marque doit faire au moins {{ limit }} caractères, {{ value }} est trop court", maxMessage: 'La marque doit faire au maximum {{ limit }} caractères')]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    #[ORM\Column(length: 50)]
    private ?string $marque = null;

    #[Assert\Length(min: '2', max: 55, minMessage: "Le modèle doit faire au moins {{ limit }} caractères, {{ value }} est trop court", maxMessage: 'Le modèle doit faire au maximum {{ limit }} caractères')]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    #[ORM\Column(length: 50)]
    private ?string $modele = null;

    #[Assert\Length(min: '2', max: 1500, minMessage: "La description doit faire au moins {{ limit }} caractères, {{ value }} est trop court", maxMessage: 'La description doit faire au maximum {{ limit }} caractères')]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    #[ORM\Column]
    private ?float $prix_journalier = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_enregistrement = null;

    #[ORM\OneToMany(mappedBy: 'vehicule', targetEntity: Commande::class)]
    private Collection $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrixJournalier(): ?float
    {
        return $this->prix_journalier;
    }

    public function setPrixJournalier(float $prix_journalier): static
    {
        $this->prix_journalier = $prix_journalier;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->date_enregistrement;
    }

    public function setDateEnregistrement(\DateTimeInterface $date_enregistrement): static
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setVehicule($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getVehicule() === $this) {
                $commande->setVehicule(null);
            }
        }

        return $this;
    }
}
