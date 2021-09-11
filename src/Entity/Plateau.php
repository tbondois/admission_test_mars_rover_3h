<?php

namespace App\Entity;

use App\Repository\PlateauRepository;
use Symfony\Component\Validator\Constraints as Assert;

class Plateau
{
    /**
     * @var Position
     * @Assert\NotNull
     */
    private $maxPosition;

    public function __toString(): string
    {
        return (string)$this->getMaxPosition();
    }

    public function getMaxPosition(): Position
    {
        return $this->maxPosition;
    }

    public function setMaxPosition(Position $position): self
    {
        $this->maxPosition = $position;

        return $this;
    }
}
