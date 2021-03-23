<?php


use JetBrains\PhpStorm\Pure;

class DistComparator
{
    private float $distance;

    function __construct( $distance ) {
        $this->distance = $distance;
    }

    #[Pure] static function isNearLocation($my_location, $other_location, $range): int
    {
        $dist_squared = pow(($my_location->x_ratio * 100) - ($other_location->x_ratio * 100), 2) +
            pow(($my_location->y_ratio * 100) - ($other_location->y_ratio * 100), 2);
        if ($my_location->pk == $other_location->pk) {
            return -1;
        }
        $distance = sqrt($dist_squared);
        if ($distance <= $range) {return 0;}
        return -1;
    }

    /** @noinspection PhpUnused */
    #[Pure] function call($a, $b ): int
    {
        return DistComparator::isNearLocation($a, $b, $this->distance);
    }
}