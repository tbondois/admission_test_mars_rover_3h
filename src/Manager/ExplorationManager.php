<?php


namespace App\Manager;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use App\Entity\Rover;
use App\Entity\Position;
use App\Entity\Plateau;
use function PHPUnit\Framework\throwException;

class ExplorationManager implements ExplorationManagerInterface
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

    public function __construct(SerializerInterface $serializer,
                                ValidatorInterface $validator,
                                EntityManagerInterface $entityManager,
                                RoverMovementManager $roverMovementManager
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->roverMovementManager = $roverMovementManager;
    }


    public function sendInstructions($jsonInput): JsonResponse
    {
        $outputs = [];

        $arrayInput = $this->serializer->decode($jsonInput, "json");
        if (!isset($arrayInput["plateau"])) {
            throw new \Exception("Plateau information required");
        }

        $plateau = $this->createPlateau($arrayInput["plateau"]);

        $rovers = [];
        if (isset($arrayInput["rovers"])) {
            foreach ($arrayInput["rovers"] as $roverNumber => $arrayInputRover) {
                $rovers[] = $this->createRover($arrayInputRover["position"], $arrayInputRover["moveset"], $roverNumber);
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

            $outputs[] = $rover->getPosition()->getX()
                . " "
                . $rover->getPosition()->getY()
                . " "
                . $rover->getPosition()->getOrientation()
            ;

        }

        return new JsonResponse(
            $this->serializer->normalize($outputs, "json"),
            201,
        );
    }




    private function createPlateau(string $strPosition)
    {

        $position = $this->createPosition($strPosition);
        $plateau = new Plateau();
        $plateau->setMaxPosition($position);
        //$this->entityManager->persist($plateau);
        return $plateau;
    }

    private function createRover(string $strPosition, string $moveset, int $roverNumber)
    {
        $rover = new Rover();
        $position = $this->createPosition($strPosition);
        $rover->setPosition($position);
        $rover->setMoveset($moveset);
        $rover->setId($roverNumber);
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


        $this->validate($position);

        if (isset($params[2])) {
            $position->setOrientation($params[2]);
        }
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
            throw new \Exception("Violation(s) on ". get_class($entity)." validation : ".implode(" | ", $violationList));
        }
    }

} // end class
