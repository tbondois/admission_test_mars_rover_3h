<?php

namespace App\Entity;

use App\Repository\RoverRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TODO : Asserts
 * @ORM\Entity(repositoryClass=RoverRepository::class)
 */
class Rover
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ?Position
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity=Position::class, inversedBy="rovers")
     */
    private $position;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=500)
     */
    private $moveset;


    public function __toString(): string
    {
        return "Rover #{$this->id} at {$this->getPosition()}";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ?int
    {
        return $this->id = $id;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getMoveset(): ?string
    {
        return $this->moveset;
    }

    public function setMoveset(string $moveset): self
    {
        $this->moveset = trim(str_replace(' ', '', $moveset));

        return $this;
    }

    
}
