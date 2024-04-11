<?php

function searchForLittleEndianInt($filename, $searchValue) {
    // Open the binary file for reading
    $file = fopen($filename, 'rb');
    
    if ($file === false) {
        die("Error opening file");
    }

    // Read the file by 4-byte chunks
    while (!feof($file)) {
        $data = fread($file, 4);

        if ($data === false) {
            die("Error reading file");
        }

        // Unpack the 4 bytes as a little-endian integer
        $value = unpack('V', $data)[1];

        // Check if the value matches the search value
        if ($value == $searchValue) {
            echo dechex(0x8c010000 + ftell($file));
            fclose($file);
            return true;
        }
    }

    // Close the file
    fclose($file);

    // If the value is not found, return false
    return false;
}

// Example usage
$filename = 'build/tbg.bin';
$searchValue = 0x8c001000; // Replace with the value you're searching for

if (searchForLittleEndianInt($filename, $searchValue)) {
    echo "Value found in the file.\n";
} else {
    echo "Value not found in the file.\n";
}