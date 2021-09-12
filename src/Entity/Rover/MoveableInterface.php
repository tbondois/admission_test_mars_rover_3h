<?php

namespace App\Entity\Rover;

use App\Entity\Plateau;

interface MoveableInterface
{
    public function moveNorth(Plateau $plateau): self;

    public function moveSouth(Plateau $plateau): self;

    public function moveWest(Plateau $plateau): self;

    public function moveEast(Plateau $plateau): self;

}
