<?php


namespace App\Manager;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use App\Entity\Rover;
use App\Entity\Position;
use App\Entity\Plateau;

class ExplorationManager
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RoverMovementManager
     */
    private $roverMovementManager;

    public function __construct(SerializerInterface    $serializer,
                                ValidatorInterface     $validator,
                                EntityManagerInterface $entityManager,
                                RoverMovementManager   $roverMovementManager
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->roverMovementManager = $roverMovementManager;
    }

    public function normalizeInput(string $input): iterable
    {
        $normalizedInputData = [];
        $rows = explode(PHP_EOL, $input);
        $normalizedInputData["plateau"] = trim(array_shift($rows));
        $normalizedInputData["rovers"] = [];
        $roverId = 1;
        foreach ($rows as $number => $row) {
            if ($number % 2 === 0) {
                $normalizedInputData["rovers"][$roverId]["position"] = trim($row);
            } else {
                $normalizedInputData["rovers"][$roverId]["moveset"] = trim($row);
                $roverId++;
            }
        }
        return $normalizedInputData;
    }

    public function sendInstructions($normalizedInputData): iterable
    {
        $roverEndingPositions = [];

        if (!isset($normalizedInputData["plateau"])) {
            throw new \Exception("Plateau information required");
        }

        $plateau = $this->createPlateau($normalizedInputData["plateau"]);

        $rovers = [];
        if (isset($normalizedInputData["rovers"])) {
            foreach ($normalizedInputData["rovers"] as $arrayInputRover) {
                $rovers[] = $this->createRover($arrayInputRover["position"], $arrayInputRover["moveset"]);
            }
        }

        if (!count($rovers)) {
            throw  new \Exception("At leat one rover required in the squad !");
        }


        foreach ($rovers as $roverNumber => $rover) {
            $positions[$roverNumber] = [];

            $directions = $this->roverMovementManager->getIterableMoves($rover->getMoveset());

            foreach ($directions as $directionNumber => $direction) {
                $this->roverMovementManager->controlRover($rover, $direction, $plateau);
            }

            $roverEndingPositions[] = (string)$rover->getPosition();
        }
        //$this->entityManager->flush();

        return $roverEndingPositions;
    }


    private function createPlateau(string $strPosition)
    {

        $position = $this->createPosition($strPosition);
        $plateau = new Plateau();
        $plateau->setMaxPosition($position);

        $this->validate($plateau);
        //$this->entityManager->persist($plateau);

        return $plateau;
    }

    private function createRover(string $strPosition, string $moveset)
    {
        $rover = new Rover();
        $position = $this->createPosition($strPosition);
        $rover->setPosition($position);
        $rover->setMoveset($moveset);

        $this->validate($rover);
        //$this->entityManager->persist($rover);

        return $rover;
    }


    private function createPosition(string $strPosition)
    {
        $params = explode(" ", $strPosition);

        if (!isset($params[0]) || !isset($params[1])) {
            throw new \Exception("invalid position format");
        }
        $position = new Position();
        $position->setX($params[0]);
        $position->setY($params[1]);
        if (isset($params[2])) {
            $position->setOrientation($params[2]);
        }

        $this->validate($position);
        //$this->entityManager->persist($position);

        return $position;
    }


    /**
     * Use Validator rules
     */
    protected function validate(object $entity)
    {
        /** @var ConstraintViolationListInterface $violationList */
        $violationList = $this->validator->validate($entity);
        if (count($violationList)) {
            throw new \Exception("Violation(s) on ".get_class($entity)." validation : ".implode(" | ", $violationList));
        }
    }

} // end class
