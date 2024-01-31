<?php

$name = $argv[1];

$dec = hexdec($name) - 0x8c010000;
$dec = str_pad((string) $dec, 6, "0", STR_PAD_LEFT);
echo "_{$dec}_{$name}.src\n";
