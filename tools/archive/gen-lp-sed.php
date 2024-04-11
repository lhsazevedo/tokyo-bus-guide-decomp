<?php

if ($argc != 3) {
    $bin = $argv[0];
    echo "Usage: $bin <file> <line>";
}

$firstLine = (int) $argv[2] - 1;
$lines = file($argv[1]);

$initAddr = hexdec(substr(trim($lines[$firstLine]), -8));
$addr = $initAddr;
$line = $firstLine;
$offset = 0;

if ($initAddr < 0x8c000000) die('bad init addr');

$lnksub = file('lnk.sub');

$defines = [];
$curDefines = [];
foreach ($lnksub as $ls) {
    if (str_starts_with($ls, "define")) {
        $curSymbol = substr($ls, 7, -12);
        $curTarget = substr($ls, -11, 8);
        $curDefines[] = [$curSymbol, $curTarget];
    }
}

$imports = [];
$curImports = [];
foreach ($lines as $l) {
    $parts = array_values(array_filter(explode(' ', $l)));
    if ($parts[0] == ".IMPORT") {
        $curImports[] = trim($parts[1]);
    }
}

$label = 'LP_GEN_' . rand(10000,99999);

$shLines = [];

while (trim($lines[$line]) != "") {
    $str = $lines[$line];

    $parts = array_values(array_filter(explode(' ', trim($str))));
    $directive = $parts[0];
    $target = substr($parts[1], 2, 8);

    if (str_starts_with($directive, '.DATA')) {
        $shLines[] = "sed -i \"s/H'" . dechex($addr) . "/$label+" . $offset . "/g\" " . $argv[1] . "\n";

        if (str_starts_with($target, "8C")) {
            $symbol = "__" . strtolower($target);

            $curDefIndex = array_search($target, array_column($curDefines, 1));
            if ($curDefIndex) {
                $symbol = $curDefines[$curDefIndex][0]; 
            }

            if (!in_array($symbol, $curImports)) {
                $imports[] = $symbol;
            }

            $shLines[] = "sed -i \"s/H'" . $target . "/" . $symbol . "/g\" " . $argv[1] . "\n";

            if (!$curDefIndex) {
                $defines[] = [$symbol, $target];
            }
        }

        $shLines[] = "\n";
    }

    if (str_ends_with($directive, '.W')) {
        $offset += 2;
        $addr += 2;
    } elseif (str_ends_with($directive, '.L')) {
        $offset += 4;
        $addr += 4;
    }

    $line++;
}

echo "Writing lp_labels.sh...\n";
file_put_contents('tools/lp_labels.sh', join("", $shLines));

$defineLines = [];
foreach ($defines as $define) {
    $defineLines[] = "define " . $define[0] . "(" . $define[1] . ")\r\n";
}

for ($i=count($lnksub)-1; ; $i--) {
    if ($i < 0) die('Couldn\' find define insert location in lnk.sub');
    
    if (str_starts_with(trim($lnksub[$i]), 'define ')) {
        echo "Writing defines...\n";
        array_splice($lnksub, $i, 0, $defineLines);
        file_put_contents('lnk.sub', join($lnksub));
        break;
    }
}   

$importLines = [];
foreach ($imports as $import) {
    $importLines[] = "          .IMPORT     " . $import . "\r\n";
}
for ($i=count($lines)-1; ; $i--) {
    if ($i < 0) die("Couldn' find .IMPORT insert location in src file. Imports:\n" . join($importLines));
    
    if (str_starts_with($lines[$i], '          .IMPORT ')) {
        echo "Writing imports...\n";
        array_splice($lines, $i, 0, $importLines);
        file_put_contents($argv[1], join($lines));
        break;
    }
}

