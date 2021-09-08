<?php


namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Rover;
use App\Entity\Position;
use App\Entity\Plateau;

class RoverMovementManager
{

    public function controlRover(Rover $rover, string $direction, Plateau $plateau) : Position
    {
        switch ($direction) {
            case "M":
                $this->moveForward($rover, $plateau);
                break;
            case "L":
                $this->rotateLeft($rover);
                break;
            case "R":
                $this->rotateRight($rover);
                break;
            default:
                throw new \Exception("Unknow direction : $direction for $rover");
        }
        return $rover->getPosition();
    }

    public function moveForward(Rover $rover, Plateau $plateau)
    {
        $newPosition = $rover->getPosition();

        switch (strtoupper($rover->getPosition()->getOrientation())) {
            case "N":
                $newPosition->addY();
                break;
            case "S":
                $newPosition->addY(-1);
                break;
            case "W":
                $newPosition->addX(-1);
                break;
            case "E":
                $newPosition->addX();
                break;
            default:
                throw new \Exception("Unable to rotate right (unknown landing base orientation) for $rover");
        }

        if ($newPosition->getX() < 0
            || $newPosition->getX() > $plateau->getMaxPosition()->getX()
            || $newPosition->getY() < 0
            || $newPosition->getY() > $plateau->getMaxPosition()->getY()
        ) {
            throw new \Exception("impossible to move outside of plateau for $rover");
        }

        $rover->setPosition($newPosition);
    }

    public function rotateLeft(Rover $rover)
    {
        switch (strtoupper($rover->getPosition()->getOrientation())) {
            case "N":
                $rover->getPosition()->setOrientation("W");
                break;
            case "W":
                $rover->getPosition()->setOrientation("S");
                break;
            case "S":
                $rover->getPosition()->setOrientation("E");
                break;
            case "E":
                $rover->getPosition()->setOrientation("N");
                break;
            default:
                throw new \Exception("Unable to rotate right (unknown base orientation) for $rover");
        }
    }

    public function rotateRight(Rover $rover)
    {
        switch (strtoupper($rover->getPosition()->getOrientation())) {
            case "N":
                $rover->getPosition()->setOrientation("E");
                break;
            case "E":
                $rover->getPosition()->setOrientation("S");
                break;
            case "S":
                $rover->getPosition()->setOrientation("W");
                break;
            case "W":
                $rover->getPosition()->setOrientation("N");
                break;
            default:
                throw new \Exception("Unable to rotate right (unknown base orientation) for $rover");
        }

    }


    public function getIterableMoves(string $moveset) : iterable
    {
        return str_split($moveset);
    }
} // end class
