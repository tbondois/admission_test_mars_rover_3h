<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\InstructionEnum;
use App\ValueObject\Instruction\InstructionInterface;
use App\ValueObject\Instruction\InstructionMove;
use App\ValueObject\Instruction\InstructionRotateLeft;
use App\ValueObject\Instruction\InstructionRotateRight;

class InstructionFactory implements InstructionFactoryInterface
{
    public function createInstruction(string $instructionCommand): InstructionInterface
    {
        $instructionCommand = strtoupper($instructionCommand);

        switch ($instructionCommand) {
            case InstructionEnum::INSTRUCTION_VALUE_MOVE_FORWARD:
                return new InstructionMove();
            case InstructionEnum::INSTRUCTION_VALUE_ROTATE_LEFT:
                return new InstructionRotateLeft();
            case InstructionEnum::INSTRUCTION_VALUE_ROTATE_RIGHT:
                return new InstructionRotateRight();
            default:
                throw new \RangeException("Invalid instruction $instructionCommand");
        }
    }


}
