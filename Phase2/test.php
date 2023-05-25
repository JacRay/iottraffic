<?php

function calculateThirdPoint($x1, $y1, $x2, $y2)
{
    // Calculate the slope of the line passing through (x1, y1) and (x2, y2)
    $slope = ($y2 - $y1) / ($x2 - $x1);

    // Determine the negative reciprocal to get the perpendicular slope
    $perpendicularSlope = -1 / $slope;

    // Calculate the coordinates of the third point
    $distance = 0.0001; // Distance from (x1, y1)

    $x3 = $x1 - ($distance / sqrt(1 + pow($perpendicularSlope, 2)));
    $y3 = $y1 - ($distance * $perpendicularSlope / sqrt(1 + pow($perpendicularSlope, 2)));

    return [$x3, $y3];
}
//North +
//South -
// Test the function with sample points
$p1 = [9.935632, 76.271555];
$p2 = [9.935603, 76.271585];

$result = calculateThirdPoint($p1[0], $p1[1], $p2[0], $p2[1]);
echo "Coordinates of the third point: (" . $result[0] . ", " . $result[1] . ")";

?>
