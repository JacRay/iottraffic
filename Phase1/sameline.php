<?php

function calculateThirdPoint($x1, $y1, $x2, $y2)
{
    $distance = sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));

    // Calculate the unit vector (dx, dy)
    $dx = ($x1 - $x2) / $distance;
    $dy = ($y1 - $y2) / $distance;

    // Calculate the coordinates of the third point
    $x3 = $x1 + 0.00001 * $dx;
    $y3 = $y1 + 0.00001 * $dy;

    return [$x3, $y3];
    // Calculate the slope of the line passing through (x1, y1) and (x2, y2)
    // $slope = ($y2 - $y1) / ($x2 - $x1);
    
    // // Calculate the angle between the line and the x-axis
    // $angle = atan($slope);
    
    // // Calculate the coordinates of the third point
    // $x3 = $x1 + 0.00001 * cos($angle);
    // $y3 = $y1 + 0.00001 * sin($angle);
    
    // return [$x3, $y3];
}

// Test the function with sample points
$x1 = 9.935573;
$y1 = 76.271558;
$x2 = 9.9356;
$y2 = 76.271526;

$result = calculateThirdPoint($x1, $y1, $x2, $y2);
echo "Coordinates of the third point: (" . $result[0] . ", " . $result[1] . ")";

?>
