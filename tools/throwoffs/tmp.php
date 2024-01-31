<?php

function dd(...$args) {
    var_dump(...$args);
    exit;
}

function dump(...$args) {
    var_dump(...$args);
}

$lineNumbers = [
    1203,
    1842,
    1867,
    1892,
    1917,
    1942,
    1967,
    1992,
    2017,
    2042,
    4220,
    4245,
    4271,
    4296,
    4321,
    4347,
    4372,
    4397,
    4422,
    5222,
    5247,
    5272,
    5297,
    5322,
    5347,
    5372,
    5397,
    5422,
    5474,
    5527,
    5579,
    5632,
    5685,
    5738,
    5791,
    5849,
    5905,
    5982,
    6071,
    6239,
    6264,
    6289,
    6485,
    6510,
    6535,
    6560,
    6585,
    6695,
    6720,
];

$lines = file('src/_008160_data.src');

foreach ($lineNumbers as $lineNumber) {
    preg_match('/([A-Za-z0-9_]{5,})/', $lines[$lineNumber - 1], $matches);

    echo $matches[1] . "\n";
}

