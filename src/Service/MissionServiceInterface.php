<?php

namespace App\Service;

use App\Entity\Mission;

interface MissionServiceInterface
{
    public function runInput(string $input): Mission;
}
