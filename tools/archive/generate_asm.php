<?php

// Naive PHP script used to generate the assembly files with raw bytes

$f = fopen('1ST_READ.BIN', 'r');

$out = '';
$addr = 0x8c010000;

while (!feof($f)) {
    $str = fread($f, 16);

    $data = [];

    foreach(str_split($str) as $c) {
        $data[] .= 'H\'' . strtoupper(bin2hex($c));
    }

    $line = '          .DATA.B ';
    $line .= join(', ', $data);
    $line .= '; H\'' . dechex($addr);

    $out .= $line . "\n";
    $addr += 16;
}

$f = fopen('full.s', 'w');
fwrite($f, $out);
