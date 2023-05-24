<?php

function calculateThirdPoint($x1, $y1, $x2, $y2)
{
    // Calculate the slope of the line passing through (x1, y1) and (x2, y2)
    $slope = ($y2 - $y1) / ($x2 - $x1);

    // Determine the negative reciprocal to get the perpendicular slope
    $perpendicularSlope = -1 / $slope;

    // Calculate the coordinates of the third point
    $distance = 10; // Distance from (x1, y1)

    $x3 = $x1 + ($distance / sqrt(1 + pow($perpendicularSlope, 2)));
    $y3 = $y1 + ($distance * $perpendicularSlope / sqrt(1 + pow($perpendicularSlope, 2)));

    return [$x3, $y3];
}

// Test the function with sample points
$x1 = 1;
$y1 = 2;
$x2 = 5;
$y2 = 8;

$result = calculateThirdPoint($x1, $y1, $x2, $y2);
echo "Coordinates of the third point: (" . $result[0] . ", " . $result[1] . ")";

?>
