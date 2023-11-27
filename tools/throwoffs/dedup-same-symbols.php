<?php

function dd(...$args) {
    var_dump(...$args);
    exit;
}

$filename = 'src/_008160_8c011fe0.src';
$contents = file_get_contents($filename);

preg_match_all('/^([a-zA-Z0-9._]+):/m', $contents, $matches);
$symbols = array_unique($matches[1]);
unset($matches);

$symbolsWithAddresses = [];
foreach ($symbols as $symbol) {
    if (preg_match('/_([a-fA-F0-9]{8})$/', $symbol, $matches)) {
        $symbolsWithAddresses[] = [$symbol, hexdec($matches[1])];
    }
}

preg_match_all('/DATA.L\s+([a-zA-Z0-9._]{3,})/m', $contents, $matches);
$refs = array_unique($matches[1]);

$refsWithAddresses = [];
foreach ($refs as $ref) {
    if (preg_match('/_([a-fA-F0-9]{8})$/', $ref, $matches)) {
        $refsWithAddresses[] = [$ref, hexdec($matches[1])];
    }
}

foreach ($symbolsWithAddresses as $symbol) {
    $s = array_filter($refsWithAddresses, function ($r) use ($symbol) { return $symbol[1] === $r[1] && $symbol[0] !== $r[0]; });

    if (!empty($s)) {
        echo $symbol[0] . ":\n";
        foreach ($s as $ts) {
            echo '- ' . $ts[0] . "\n";
            $contents = str_replace($ts[0], $symbol[0], $contents);
        }
    }
}

file_put_contents($filename, $contents);
