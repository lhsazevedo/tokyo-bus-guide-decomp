<?php

// Function to transform the matched string to uppercase
function transformToUpper($matches) {
    return strtoupper($matches[0]);
}

// File path
$filePath = 'src/_024908_8c01614c.src';

// Read the content of the file
$fileContent = file_get_contents($filePath);

// Define the regex pattern
$pattern = '/f?r\d+/i';

// Apply the transformation using preg_replace_callback
$transformedContent = preg_replace_callback($pattern, 'transformToUpper', $fileContent);

// Write the modified content back to the file
file_put_contents($filePath, $transformedContent);

echo "File has been updated successfully!\n";
