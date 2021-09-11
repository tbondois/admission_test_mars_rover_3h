<?php

namespace App\Entity;

use App\Repository\RoverRepository;
use Symfony\Component\Validator\Constraints as Assert;

class Rover
{
    /**
     * @var Position
     * @Assert\NotNull
     */
    private $position;

    /**
     * @Assert\NotBlank
     */
    private string $moveset;


    public function __toString(): string
    {
        return "Rover {$this->id} at position {$this->getPosition()}";
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getMoveset(): string
    {
        return $this->moveset;
    }

    public function setMoveset(string $moveset): self
    {
        $this->moveset = trim(str_replace(' ', '', $moveset));

        return $this;
    }

}
