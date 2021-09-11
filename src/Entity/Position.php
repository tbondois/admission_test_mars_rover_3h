<?php

namespace App\Entity;

use App\Repository\PositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class Position
{
    /**
     * @Assert\NotNull
     * @Assert\PositiveOrZero
     */
    private int $x;

    /**
     * @Assert\NotNull
     * @Assert\PositiveOrZero
     */
    private int $y;

    /**
     * @Assert\Choice({"N", "W", "S", "E", null})
     */
    private ?string $orientation;

    /**
     * @var ArrayCollection|Rover[]
     */
    private iterable $rovers;

    public function __construct()
    {
        $this->rovers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return trim(sprintf("%d %d %s", $this->x, $this->y,$this->orientation));
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
