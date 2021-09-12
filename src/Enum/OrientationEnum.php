<?php

namespace App\Enum;

abstract class OrientationEnum
{
    const CARDINALPOINT_VALUE_NORTH = "N";
    const CARDINALPOINT_VALUE_SOUTH = "S";
    const CARDINALPOINT_VALUE_WEST  = "W";
    const CARDINALPOINT_VALUE_EAST  = "E";

    const CARDINALPOINT_VALUES = [
        self::CARDINALPOINT_VALUE_NORTH,
        self::CARDINALPOINT_VALUE_SOUTH,
        self::CARDINALPOINT_VALUE_WEST,
        self::CARDINALPOINT_VALUE_EAST,
    ];
}
