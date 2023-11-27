<?php

if ($argc != 2) {
    $bin = $argv[0];
    echo "Usage: $bin <file>";
    die;
}

$input = file($argv[1]);
if (!$input) die("Cannot open $input\n");

// Defines
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

// Imports
$imports = [];
$curImports = [];
foreach ($input as $l) {
    $parts = array_values(array_filter(explode(' ', $l)));
    if ($parts[0] == ".IMPORT") {
        $curImports[] = trim($parts[1]);
    }
}

$lno = 0;
$lpStart = null;
$lpEnd = null;

$largestLp = 0;

$lps = [];

while ($lno < count($input)) {
    // Look for the next LP
    $line = $input[$lno];

    if (preg_match('/ ; H\'([0-9A-F]+)/', $line, $matches) !== 1) {
        $lno++;
        continue;
    }

    // Generate and add label.
    $label = 'LP_GEN_' . rand(10000, 99999);
    array_splice($input, $lno, 0, [$label . ":\r\n"]);
    $lno++;

    // print_r(array_slice($input, 0, $lno+10));
    // var_dump($input[$lno]);
    // die;

    $lpStart = $lno;
    $lpStartAddress = hexdec($matches[1]);

    while ($lno < count($input) && preg_match('/ ; H\'([0-9A-F]+)/', $input[$lno], $dataMatches) == 1) {
        $lpLine = $input[$lno];
        $lpDataAddress = hexdec($dataMatches[1]);
        $offset = $lpDataAddress - $lpStartAddress;
        [$directive, $value] = array_filter(explode(' ', trim($lpLine)));

        if (str_starts_with($directive, '.DATA')) {
            $sedCommands[] = "s/H'" . dechex($lpDataAddress) . "/$label+" . $offset . "/g\n";

            if (str_starts_with($directive, '.DATA.L') && str_starts_with($value, "H'8C")) {
                $hexValue = substr($value, -8);
                $symbol = "__" . strtolower($hexValue);

                $curDefIndex = array_search($hexValue, array_column($curDefines, 1));
                if ($curDefIndex) {
                    $symbol = $curDefines[$curDefIndex][0]; 
                } elseif (!in_array($symbol, array_column($defines, 0))) {
                    $defines[] = [$symbol, $hexValue];
                }

                if (!in_array($symbol, $curImports) && !in_array($symbol, $imports)) {
                    $imports[] = $symbol;
                }

                $sedCommands[] = "s/H'" . $hexValue . "/" . $symbol . "/g\n";
            }
        }

        $lpEnd = $lno;
        $lno++;
    }
}

echo "Writing lp_labels.sh...\n";
file_put_contents('tools/lp_labels_commands.txt', join("", $sedCommands));

$defineLines = [];
foreach ($defines as $define) {
    $defineLines[] = "define " . $define[0] . "(" . $define[1] . ")\r\n";
}

for ($i=count($lnksub)-1; ; $i--) {
    if ($i < 0) die('Couldn\' find define insert location in lnk.sub');
    
    if (str_starts_with(trim($lnksub[$i]), 'define ')) {
        echo "Writing defines...\n";
        array_splice($lnksub, $i, 0, $defineLines);
        file_put_contents('lnk.sub.2', join($lnksub));
        break;
    }
}   

$importLines = [];
foreach ($imports as $import) {
    $importLines[] = "          .IMPORT     " . $import . "\r\n";
}
for ($i=count($input)-1; ; $i--) {
    if ($i < 0) die("Couldn' find .IMPORT insert location in src file. Imports:\n" . join($importLines));
    
    if (str_starts_with($input[$i], '          .IMPORT ')) {
        echo "Writing imports...\n";
        array_splice($input, $i, 0, $importLines);
        file_put_contents($argv[1] . '.2', join($input));
        break;
    }
}
