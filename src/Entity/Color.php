<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, Card>
     */
    #[ORM\OneToMany(targetEntity: Card::class, mappedBy: 'color')]
    private Collection $cards;

    /**
     * @var Collection<int, Ressource>
     */
    #[ORM\OneToMany(targetEntity: Ressource::class, mappedBy: 'color')]
    private Collection $ressources;

    #[ORM\Column(length: 255)]
    private ?string $symbole = null;

    #[ORM\Column(length: 255)]
    private ?string $frame = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stats = null;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->ressources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): static
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
            $card->setColor($this);
        }

        return $this;
    }

    public function removeCard(Card $card): static
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getColor() === $this) {
                $card->setColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ressource>
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): static
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources->add($ressource);
            $ressource->setColor($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): static
    {
        if ($this->ressources->removeElement($ressource)) {
            // set the owning side to null (unless already changed)
            if ($ressource->getColor() === $this) {
                $ressource->setColor(null);
            }
        }

        return $this;
    }

    public function getSymbole(): ?string
    {
        return $this->symbole;
    }

    public function setSymbole(string $symbole): static
    {
        $this->symbole = $symbole;

        return $this;
    }

    public function getFrame(): ?string
    {
        return $this->frame;
    }

    public function setFrame(string $frame): static
    {
        $this->frame = $frame;

        return $this;
    }

    public function getStats(): ?string
    {
        return $this->stats;
    }

    public function setStats(?string $stats): static
    {
        $this->stats = $stats;

        return $this;
    }
}
