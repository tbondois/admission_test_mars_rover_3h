<?php

declare(strict_types=1);

namespace App\ValueObject\Instruction;

use App\Enum\InstructionEnum;
use App\Enum\OrientationEnum;
use App\Entity\Rover;
use App\Entity\Mission;

class InstructionRotateLeft extends AbstractInstruction
{
    public function __construct()
    {
        $this->instructionLetter = InstructionEnum::INSTRUCTION_VALUE_ROTATE_LEFT;
    }

    public function execute(Rover $rover, Mission $mission): Rover
    {
        switch ($rover->getOrientationCardinalPoint()) {
            case OrientationEnum::CARDINALPOINT_VALUE_NORTH:
                return $rover->orientWest();
            case OrientationEnum::CARDINALPOINT_VALUE_WEST:
                return $rover->orientSouth();
            case OrientationEnum::CARDINALPOINT_VALUE_SOUTH:
                return $rover->orientEast();
            case OrientationEnum::CARDINALPOINT_VALUE_EAST:
                return $rover->orientNorth();
            default:
                throw new \RangeException("Unable to rotate left (unsupported base orientation) for $rover");
        }
    }

}
