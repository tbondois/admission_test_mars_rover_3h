<?php

namespace App\Entity\Rover;

interface RotatableInterface
{
    public function orientNorth(): self;

    public function orientSouth(): self;

    public function orientEast(): self;

    public function orientWest(): self;

}
