<?php

namespace App\Entity;

use App\Repository\PlateauRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlateauRepository::class)
 */
class Plateau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Position
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity=Position::class, inversedBy="rovers")
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
