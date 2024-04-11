<?php

function deduplicateSymbols($assemblyFile)
{
    // Read the assembly file
    $lines = file($assemblyFile);

    // Track symbol occurrences
    $symbolOccurrences = [];

    // Iterate through lines
    foreach ($lines as $index => $line) {
        // Extract symbol name
        if (preg_match('/^([a-zA-Z0-9_]+):/', $line, $matches)) {
            $symbol = $matches[1];

            // Check if symbol already occurred
            if (isset($symbolOccurrences[$symbol])) {
                // Increment occurrence count
                $symbolOccurrences[$symbol]++;
                // Append incrementing suffix to the symbol
                $newSymbol = $symbol . '_' . $symbolOccurrences[$symbol];
                // Replace the original line with the new symbol
                $lines[$index] = $newSymbol . ":\r\n";
            } else {
                // First occurrence of the symbol, add it to the occurrences array
                $symbolOccurrences[$symbol] = 0;
            }
        }
    }

    // Update the assembly file with deduplicated symbols
    file_put_contents($assemblyFile, join($lines));

    echo "Deduplication complete.\n";
}

// Example usage
$assemblyFile = 'src/_024908_8c01614c.src';
deduplicateSymbols($assemblyFile);
