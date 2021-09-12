<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Mission;

class MissionService implements MissionServiceInterface
{
    protected InputDeserializerInterface $inputDeserializer;

    public function __construct(InputDeserializerInterface $inputDeserializer)
    {
        $this->inputDeserializer = $inputDeserializer;
    }

    public function runInput(string $input): Mission
    {
        $mission = $this->inputDeserializer->deserializeMission($input);

        $rovers = $mission->getRoverSquad()->getRovers();

        foreach ($rovers as $rover) {

            foreach ($rover->getInstructions() as $instruction) {
                $instruction->execute($rover, $mission);
            }
        }
        return $mission;
    }

}
