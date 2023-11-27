<?php

$contents = file_get_contents('1ST_READ.BIN');

preg_match_all('/(...\x8c)/m', $contents, $matches);

echo count($matches[1]) . PHP_EOL;

foreach ($matches[1] as $match) {
    $dec = unpack('V', $match)[1];
    // var_dump($dec);
    // die;
    if (($dec >= 0x8C03BD80) && ($dec < 0x8c04f6c0)) {
        echo 'init_' . dechex($dec) . "\n";
    }
}
