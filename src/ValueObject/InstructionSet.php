<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\ValueObject\Instruction\InstructionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class InstructionSet
{
    /**
     * @var ArrayCollection|InstructionInterface[]
     * @Assert\Count(min = 1)
     */
    private ArrayCollection $instructions;

    private bool $executed = false;

    public function __construct(ArrayCollection $instructions)
    {
        $this->instructions = $instructions;
    }

    public function serialize(): string
    {
        $str = "";
        foreach($this->getInstructions() as $instructions) {
            $str.= $instructions->serialize()."\n";
        }
        return $str;
    }

    /**
     * Getter of rovers
     * @return ArrayCollection|InstructionInterface[]
     */
    public function getInstructions(): ArrayCollection
    {
        return $this->instructions;
    }

    /**
     * Getter of executed
     *
     * @return bool
     */
    public function isExecuted(): bool
    {
        return $this->executed;
    }

    /**
     * Fluent setter of executed
     *
     * @return self
     */
    public function setExecuted(bool $executed): self
    {
        $this->executed = $executed;
        return $this;
    }

}
