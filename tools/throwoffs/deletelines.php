<?php

function deleteLinesFromFile($filePath, $lineNumbersToDelete) {
    // Read the entire file into an array
    $lines = file($filePath);

    // Open the file for writing
    $file = fopen($filePath, 'w');

    // Iterate through each line
    foreach ($lines as $lineNumber => $line) {
        // Check if the current line number is in the array of lines to delete
        if (!in_array($lineNumber + 1, $lineNumbersToDelete)) {
            // If not, write the line to the file
            fwrite($file, $line);
        }
    }

    // Close the file
    fclose($file);
}

// Example usage
$filePath = 'src/_008160_8c011fe0.src';
$linesToDelete = [
    10,
    11,
    12,
    13,
    30,
    56,
    160,
    211,
    224,
    229,
    230,
    232,
    239,
    245,
    249,
];

deleteLinesFromFile($filePath, $linesToDelete);

echo "Lines deleted successfully.";

?>
