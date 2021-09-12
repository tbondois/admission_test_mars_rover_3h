<?php

namespace App\ValueObject\Instruction;

use App\Entity\Rover;
use App\Entity\Mission;

interface InstructionInterface
{
    public function serialize(): string;

    public function execute(Rover $rover, Mission $mission): Rover;

}
