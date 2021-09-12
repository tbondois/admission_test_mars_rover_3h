<?php

declare(strict_types=1);

namespace App\ValueObject\Instruction;

use App\Enum\InstructionEnum;
use App\Enum\OrientationEnum;
use App\Entity\Rover;
use App\Entity\Mission;

class InstructionMove extends AbstractInstruction
{
    public function __construct()
    {
        $this->instructionLetter = InstructionEnum::INSTRUCTION_VALUE_MOVE_FORWARD;
    }

    public function execute(Rover $rover, Mission $mission): Rover
    {
        switch ($rover->getOrientationCardinalPoint()) {
            case OrientationEnum::CARDINALPOINT_VALUE_NORTH:
                return $rover->moveNorth($mission->getPlateau());
            case OrientationEnum::CARDINALPOINT_VALUE_SOUTH:
                return $rover->moveSouth($mission->getPlateau());
            case OrientationEnum::CARDINALPOINT_VALUE_WEST:
                return $rover->moveWest($mission->getPlateau());
            case OrientationEnum::CARDINALPOINT_VALUE_EAST:
                return $rover->moveEast($mission->getPlateau());
            default:
                throw new \RangeException("Unable to move (unsupported orientation) for $rover");
        }
    }

}

