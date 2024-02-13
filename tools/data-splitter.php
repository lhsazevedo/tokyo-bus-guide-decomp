<?php

declare(strict_types=1);


function dd(...$args) {
    var_dump(...$args);
    exit;
}

$dir = __DIR__ . '/../src';

$asmFilesNames = glob($dir . '/asm/*.src');

// Let's collect data from all files first

$asmFilesImports = [];
foreach ($asmFilesNames as $asmFileName) {
    $asmFile = file_get_contents($asmFileName);

    preg_match_all('/\s+.IMPORT\s+(\w+)/', $asmFile, $matches);
    $asmFilesImports[$asmFileName] = $matches[1];
}

$defs = [];
$constDefs = [];
$initDefs = [];
$varDefs = [];

$newDefs = [];
$newConstDefs = [];
$newInitDefs = [];
$newVarDefs = [];

foreach ($asmFilesNames as $asmFileName) {
    $asmFileLines = file($asmFileName);

    $currentSection = null;
    $lastLabel = null;
    $lastDecLabel = null;

    foreach ($asmFileLines as $asmFileLineIndex => $asmFileLine) {
        preg_match('/\.SECTION\s+(\w+),/', $asmFileLine, $matches);

        // Section
        if ($matches) {
            $currentSection = $matches[1];
            continue;
        }

        if (!in_array($currentSection, ['C', 'D', 'B'])) {
            continue;
        }

        // We are in section C or D or B

        preg_match('/(\w+):/', $asmFileLine, $matches);
        if (!$matches) continue;

        /** @var string $label */
        [, $label] = $matches;

        preg_match('/_([0-9a-fA-F]{8})$/', $label, $matches);
        if (!$matches) {
            continue;
        }

        $target = match ($currentSection) {
            'C' => 'constDefs',
            'D' => 'initDefs',
            'B' => 'varDefs',
        };

        if (!isset($$target[$asmFileName])) {
            $$target[$asmFileName] = [];
        }

        if (in_array($label, $$target[$asmFileName])) {
            $$target[$asmFileName] = $label;
            continue;
        }

        $defs[] = [
            'section' => $currentSection,
            'label' => $label,
            'file' => $asmFileName
        ];
        $$target[$asmFileName][] = $label;
    }
}

// /** @var string $hexLabel */
// [, $hexLabel] = $matches;

// $decLabel = hexdec($hexLabel);

// if ($lastDecLabel && ($lastDecLabel > $decLabel)) {
//     echo "OOPS $label $lastDecLabel $decLabel";
//     exit;
// }

// $lastLabel = $label;
// $lastDecLabel = $decLabel;

$alreadyImported = [];

foreach ($asmFilesImports as $importFileName => $imports) {

    foreach ($imports as $importIndex => $import) {
        if (in_array($import, $alreadyImported)) {
            continue;
        }

        // Find section
        if (!in_array(
            $import,
            array_map(
                function ($d) { return $d['label']; },
                array_filter(
                    $defs,
                    function ($d) { return in_array($d['section'], ['C', 'D', 'B']); },
                )
            )
        )) {
            continue;
        }

        echo "$import is first used in $importFileName\n";
    }
}
