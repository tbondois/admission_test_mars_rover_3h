<?php

declare(strict_types=1);

namespace App\ValueObject\Instruction;

use App\Entity\Rover;
use App\Entity\Mission;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractInstruction implements InstructionInterface
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(max=1)
     */
    protected string $instructionLetter;

    abstract function __construct();

    public function __toString(): string
    {
        return $this->serialize();
    }

    public function serialize(): string
    {
        return $this->instructionLetter;
    }

    abstract public function execute(Rover $rover, Mission $mission): Rover;

}