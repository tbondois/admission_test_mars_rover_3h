<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Enum\OrientationEnum;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Orientation
{
    /**
     * @Assert\Choice(
     *  choices=OrientationEnum::CARDINALPOINT_VALUES,
     *  message="Choose a valid Compass value"
     * )
     */
    private string $cardinalPoint;

    public function __construct(string $compass)
    {
        $this->cardinalPoint = $compass;
    }

    public function __toString(): string
    {
        return $this->serialize();
    }

    public function serialize(): string
    {
        return (string)$this->cardinalPoint;
    }

    /**
     * Getter of compass
     */
    public function getCardinalPoint(): string
    {
        return $this->cardinalPoint;
    }

    /**
     * Fluent setter of compass
     */
    public function setCardinalPoint(string $cardinalPoint): self
    {
        $this->cardinalPoint = $cardinalPoint;
        return $this;
    }

}
