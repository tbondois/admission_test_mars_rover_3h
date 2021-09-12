<?php

namespace App\Service;

use App\Entity\Mission;

interface InputDeserializerInterface
{
    public function deserializeMission(string $input): Mission;
}
