<?php

$inputFile = 'src/_024908_8c01614c.src';
$outputFile = $inputFile;

// Read the contents of the input file
$inputContent = file_get_contents($inputFile);

// Define the pattern for matching
$pattern = '/          \.DATA\.B H\'09 ; H\'[0-9A-F]+\n          \.DATA\.B H\'00 ; H\'[0-9A-F]+/';

// Define the replacement string
$replacement = "          NOP\n";

// Perform the replacement
$outputContent = preg_replace($pattern, $replacement, $inputContent, -1, $count);

// Write the modified content to the output file
file_put_contents($outputFile, $outputContent);

echo "Replacement complete, $count ocurrences. Output written to $outputFile\n";
