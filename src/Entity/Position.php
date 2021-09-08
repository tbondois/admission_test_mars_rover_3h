<?php

namespace App\Entity;

use App\Repository\PositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PositionRepository::class)
 */
class Position
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotNull
     * @Assert\PositiveOrZero
     * @ORM\Column(type="integer")
     */
    private $x;

    /**
     * @Assert\NotNull
     * @Assert\PositiveOrZero
     * @ORM\Column(type="integer")
     */
    private $y;

    /**
     * @Assert\Choice({"N", "W", "S", "E", null})
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $orientation;

    /**
     * @var ArrayCollection|Rover[]
     * @ORM\OneToMany(targetEntity=Rover::class, mappedBy="position")
     */
    private $rovers;

    public function __construct()
    {
        $this->rovers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return trim(sprintf("%d %d %s", $this->x, $this->y,$this->orientation));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }


    public function addX(int $increment = 1): self
    {
        $this->x += $increment;

        return $this;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function addY(int $increment = 1): self
    {
        $this->y += $increment;

        return $this;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function setOrientation(?string $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * @return Collection|Rover[]
     */
    public function getRovers(): Collection
    {
        return $this->rovers;
    }

    public function addRover(Rover $rover): self
    {
        if (!$this->rovers->contains($rover)) {
            $this->rovers[] = $rover;
            $rover->setPosition($this);
        }

        return $this;
    }

    public function removeRover(Rover $rover): self
    {
        if ($this->rovers->removeElement($rover)) {
            // set the owning side to null (unless already changed)
            if ($rover->getPosition() === $this) {
                $rover->setPosition(null);
            }
        }

        return $this;
    }
}
