<?php

declare(strict_types=1);

namespace App\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
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


    public function serialize(): string
    {
        return sprintf("%d %d", $this->x, $this->y);
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

}
