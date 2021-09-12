<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\Position;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Plateau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @Assert\NotNull
     * @ORM\Embedded(class="App\ValueObject\Position")
     */
    private Position $maxPosition;

    public function serialize(): string
    {
        return $this->getMaxPosition()->serialize();
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

    public function getMaxX(): int
    {
        return $this->getMaxPosition()->getX();
    }

    public function getMaxY(): int
    {
        return $this->getMaxPosition()->getY();
    }


}
