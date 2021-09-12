<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\InstructionEnum;
use App\ValueObject\Instruction\InstructionInterface;
use App\ValueObject\Instruction\InstructionMove;
use App\ValueObject\Instruction\InstructionRotateLeft;
use App\ValueObject\Instruction\InstructionRotateRight;

interface InstructionFactoryInterface
{
    public function createInstruction(string $instructionCommand): InstructionInterface;
}
