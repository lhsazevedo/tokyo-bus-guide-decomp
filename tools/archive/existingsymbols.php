<?php

// Function to find and replace hex addresses with symbols
function replaceHexWithSymbols($sourceFile)
{
    // Read the source file
    $content = file_get_contents($sourceFile);

    // Match hex addresses in the format H'deadbeef'
    preg_match_all('/BSR         H\'([a-f0-9]{8})/', $content, $matches);

    // Loop through matched hex addresses
    foreach ($matches[1] as $hexAddress) {
        // Check if a symbol is defined for the hex address
        $symbol = findSymbol($sourceFile, $hexAddress);

        // If a symbol is found, replace the hex address with the symbol
        if ($symbol) {
            $content = str_replace("H'$hexAddress", $symbol, $content);
        }
    }

    // Write the modified content back to the source file
    file_put_contents($sourceFile, $content);

    echo "Hex addresses replaced with symbols successfully.\n";
}

// Function to find a symbol for a given hex address
function findSymbol($sourceFile, $hexAddress)
{
    // Read the source file
    $content = file_get_contents($sourceFile);

    // Search for a symbol with the given hex address
    $pattern = "/(LAB|FUN)_{$hexAddress}:/";
    preg_match($pattern, $content, $matches);

    // If a match is found, return the symbol
    if (!empty($matches)) {
        return rtrim($matches[0],':');
    }

    // If no match is found, return false
    return false;
}

// Replace hex addresses with symbols in the source file
replaceHexWithSymbols('src/_024908_8c01614c.src');

