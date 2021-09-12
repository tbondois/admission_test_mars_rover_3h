<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\OrientationEnum;
use App\ValueObject\Position;
use App\ValueObject\Orientation;
use App\ValueObject\InstructionSet;
use App\Entity\Rover\MoveableInterface;
use App\Entity\Rover\RotatableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Rover implements MoveableInterface, RotatableInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $number;

    /**
     * @Assert\NotNull
     * @ORM\Embedded(class="App\ValueObject\Position")
     */
    private Position $position;

    /**
     * @Assert\NotBlank
     * @ORM\Embedded(class="App\ValueObject\Orientation")
     */
    private Orientation $orientation;

    /**
     * @ORM\Embedded(class="InstructionSet")
     */
    private InstructionSet $instructionSet;

    public function __construct(int $number, Position $position, Orientation $orientation, InstructionSet $instructions)
    {
        $this->number = $number;
        $this->position = $position;
        $this->orientation = $orientation;
        $this->instructionSet = $instructions;
    }

    public function __toString(): string
    {
        return sprintf("Rover #%d at %s", $this->number, $this->serialize());
    }

    public function serialize(): string
    {
        return sprintf("%s %s", $this->position->serialize(), $this->orientation->serialize());
    }

    public function getNumber(): int
    {
        return $this->number;
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

    public function getOrientation(): Orientation
    {
        return $this->orientation;
    }

    public function getOrientationCardinalPoint(): string
    {
        return $this->orientation->getCardinalPoint();
    }

    /**
     * Getter of instructions
     */
    public function getInstructionSet(): InstructionSet
    {
        return $this->instructionSet;
    }

    public function getInstructions(): ArrayCollection
    {
        return $this->instructionSet->getInstructions();
    }

    public function moveNorth(Plateau $plateau): self
    {
        if ($this->getPosition()->getY() >= $plateau->getMaxY()) {
            throw new \RangeException("unable move north outside of plateau for $this");
        }
        $this->position->addY();
        return $this;
    }

    public function moveSouth(Plateau $plateau): self
    {
        if ($this->getPosition()->getY() <= 0) {
            throw new \RangeException("unablemove south outside of plateau for $this");
        }
        $this->position->addY(-1);
        return $this;
    }

    public function moveWest(Plateau $plateau): self
    {
        if ($this->getPosition()->getX() <= 0) {
            throw new \RangeException("unable to move west outside of plateau for $this");
        }
        $this->position->addX(-1);
        return $this;
    }

    public function moveEast(Plateau $plateau): self
    {
        if ($this->getPosition()->getX() >= $plateau->getMaxX()) {
            throw new \RangeException("unable to move east outside of plateau for $this");
        }
        $this->position->addX(1);
        return $this;
    }

    public function orientNorth(): self
    {
        $this->orientation->setCardinalPoint(OrientationEnum::CARDINALPOINT_VALUE_NORTH);
        return $this;
    }

    public function orientSouth(): self
    {
        $this->orientation->setCardinalPoint(OrientationEnum::CARDINALPOINT_VALUE_SOUTH);
        return $this;
    }

    public function orientEast(): self
    {
        $this->orientation->setCardinalPoint(OrientationEnum::CARDINALPOINT_VALUE_EAST);
        return $this;
    }

    public function orientWest(): self
    {
        $this->orientation->setCardinalPoint(OrientationEnum::CARDINALPOINT_VALUE_WEST);
        return $this;
    }

}
