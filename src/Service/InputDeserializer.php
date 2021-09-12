<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Mission;
use App\Entity\Plateau;
use App\ValueObject\Position;
use App\ValueObject\Orientation;
use App\Entity\Rover;
use App\Entity\RoverSquad;
use App\ValueObject\InstructionSet;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Common\Collections\ArrayCollection;

class InputDeserializer implements InputDeserializerInterface
{
    protected ValidatorInterface $validator;

    protected InstructionFactoryInterface $instructionFactory;

    public function __construct(ValidatorInterface $validator, InstructionFactoryInterface $instructionFactory)
    {
        $this->validator = $validator;
        $this->instructionFactory = $instructionFactory;
    }

    public function deserializeMission(string $input): Mission
    {
        $rows = explode(PHP_EOL, $input);
        $plateau = $this->deserializePlateau(array_shift($rows));

        $dataRovers = [];
        $roverNumber = 1;
        foreach ($rows as $number => $row) {
            if ($number % 2 === 0) {
                $dataRovers[$roverNumber]["position_orientation"] = trim($row);
            } else {
                $dataRovers[$roverNumber]["instructions"] = trim($row);
                $roverNumber++;
            }
        }

        $roverSquad = $this->denormalizeRoverSquad($dataRovers);

        $mission = new Mission($plateau, $roverSquad);
        $this->validate($mission);
        return $mission;
    }


    protected function deserializePlateau(string $strPosition)
    {
        $position = $this->deserializePosition($strPosition);

        $plateau = new Plateau();
        $plateau->setMaxPosition($position);

        $this->validate($plateau);
        return $plateau;
    }

    protected function deserializePosition(string $strPosition)
    {
        $params = explode(" ", $strPosition);

        if (count($params) < 2) {
            throw new \Exception("invalid position format");
        }
        $position = new Position();
        $position->setX((int)$params[0]);
        $position->setY((int)$params[1]);

        $this->validate($position);
        return $position;
    }

    protected function denormalizeRoverSquad(array $dataRovers)
    {
        $rovers = new ArrayCollection();
        foreach ($dataRovers as $number => $dataRover) {
            $rover = $this->deserializeRover($dataRover["position_orientation"], $dataRover["instructions"], $number);
            $rovers->set($number, $rover);
        }
        $roverSquad = new RoverSquad($rovers);
        $this->validate($roverSquad);
        return $roverSquad;

    }

    protected function deserializeRover(string $inputPositionOrientation, string $instructionSet, int $number)
    {
        $params = explode(" ", $inputPositionOrientation);

        if (count($params) < 3) {
            throw new \Exception("invalid position format");
        }
        $position = $this->deserializePosition($inputPositionOrientation);
        $orientation = new Orientation($params[2]);

        $instructionSet = $this->deserializeInstructionSet($instructionSet);

        $rover = new Rover($number, $position, $orientation, $instructionSet);
        $this->validate($rover);
        return $rover;

    }

    protected function deserializeInstructionSet(string $moveset): InstructionSet
    {
        $instructions = new ArrayCollection();
        $instructionLetters = str_split($moveset);
        foreach ($instructionLetters as $instructionLetter) {
            $instruction = $this->instructionFactory->createInstruction($instructionLetter);
            $this->validate($instruction);
            $instructions->add($instruction);
        }

        $instructionSet = new InstructionSet($instructions);
        $this->validate($instructionSet);

        return $instructionSet;
    }

    /**
     * Use Validator rules
     */
    protected function validate(object $entity)
    {
        /** @var ConstraintViolationListInterface $violationList */
        $violationList = $this->validator->validate($entity);
        if (count($violationList)) {
            throw new \RangeException("Violation(s) on ".get_class($entity)." validation : ".implode(" | ", $violationList));
        }
    }

}
