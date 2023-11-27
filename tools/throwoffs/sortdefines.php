<?php

$content = file_get_contents('defines');

preg_match_all('/^define ([a-zA-Z0-9_]+)\(([a-fA-F0-9]+)\)/m', $content, $matches);

$symbols = array_combine($matches[1], array_map('hexdec', $matches[2]));

asort($symbols);

foreach ($symbols as $name => $address) {
    echo "define $name(" . strtoupper(dechex($address)) . ")\n";
}
