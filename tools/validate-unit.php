<?php

function dd(...$args) {
    var_dump(...$args);
    exit;
}

$name = $argv[1];
$contents = file_get_contents($name);
if (!$contents) die ("Error opening file $name");

preg_match_all('/^([a-zA-Z_][a-zA-Z0-9_]+):/m', $contents, $symbolMatches);
preg_match_all('/^\s+BSR\s+([a-zA-Z_][a-zA-Z0-9_]+)/m', $contents, $targetMatches);

foreach ($targetMatches[1] as $targetMatch) {
    if (!in_array($targetMatch, $symbolMatches[1])) {
        echo "$name is invalid because of $targetMatch\n";
        exit(1);
    }
}

// echo "$name is valid\n";
