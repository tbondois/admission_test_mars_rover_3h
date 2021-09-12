<?php

namespace App\Enum;

abstract class InstructionEnum
{
    const INSTRUCTION_VALUE_MOVE_FORWARD = "M";
    const INSTRUCTION_VALUE_ROTATE_LEFT  = "L";
    const INSTRUCTION_VALUE_ROTATE_RIGHT = "R";

    const INSTRUCTION_VALUES = [
        self::INSTRUCTION_VALUE_MOVE_FORWARD,
        self::INSTRUCTION_VALUE_ROTATE_LEFT,
        self::INSTRUCTION_VALUE_ROTATE_RIGHT,
    ];

}
