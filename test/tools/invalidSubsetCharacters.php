<?php
/**
 * Create a range of invalid characters for the unit tests of string subsets.
 *
 * @package HylianShield
 * @subpackage Tools
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

// Change this with the ranges of the subset you want to test.
$ranges = array(
    array('0030', '0039'),
    array('0041', '005A'),
    array('0061', '007A'),
    array('00BF', '00FF')
);

// One above the range.
$plus = function ($a) {
    $b = hexdec($a);
    return dechex(++$b);
};

// One below the range.
$min = function ($a) {
    $b = hexdec($a);
    return dechex(--$b);
};

// Keep track of both valid and invalid boundaries.
$invalid = array();
$valid = array();

// Walk through the ranges.
foreach ($ranges as $range) {
    list($start, $end) = $range;
    // Keep track of the decimal value of valid boundaries.
    $valid[] = hexdec($start);
    $valid[] = hexdec($end);

    // Add invalid characters.
    $invalid[] = $min($start);
    $invalid[] = $plus($end);
}

// Filter out characters that are tracked as invalid but are actually valid.
$invalid = array_filter(
    $invalid,
    function ($hex) use ($valid) {
        return !in_array(hexdec($hex), $valid);
    }
);

// Map all invalid characters to a readable representation.
$invalid = array_map(
    function ($hex) {
        return "'" . str_pad(strtoupper($hex), 4, '0', STR_PAD_LEFT) . "'";
    },
    $invalid
);

// Indent and spit out the result.
echo implode(",\n        ", $invalid) . PHP_EOL;
