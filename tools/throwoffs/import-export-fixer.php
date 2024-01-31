<?php

declare(strict_types=1);

function dd(...$args) {
    var_dump(...$args);
    exit;
}

$filename = $argv[1];

$lines = file($filename);

if (!$lines) die('error opening file');

// Search import
// Search export
// Search section p
// Search end

$lastImportLineIdx = null;
$lastExportLineIdx = null;
$sectionPLineIdx = null;
$endLineIdx = null;

$exports = [];
$imports = [];
$exportable = [];
$importable = [];
$newExports = [];
$newImports = [];

// Find exportable symbols
// Find importable symbols

foreach ($lines as $lineIdx => $line) {
    if (preg_match('/^\s+\.IMPORT\s+(\w+)/', $line, $matches)) {
        $lastImportLineIdx = $lineIdx;
        $imports[] = $matches[1];
        continue;
    }

    if (preg_match('/^\s+\.EXPORT\s+(\w+)/', $line, $matches)) {
        $lastExportLineIdx = $lineIdx;
        $exports[] = $matches[1];
        continue;
    }

    if (preg_match('/^\s+\.SECTION\s+P/', $line)) $sectionPLineIdx = $lineIdx;
    if (preg_match('/^\s+\.END\b/', $line)) $endLineIdx = $lineIdx;

    if (preg_match('/^(_[a-zA-Z0-9_]+):/', $line, $matches)) {
        // if (
        //     str_starts_with($matches[1], 'LAB_') ||
        //     str_starts_with($matches[1], 'LP_GEN_') ||
        //     str_starts_with($matches[1], 'caseD') ||
        //     str_starts_with($matches[1], 'switchD')
        // ) {
        //     continue;
        // }

        $exportable[] = $matches[1];
        if (!in_array($matches[1], $exports)) {
            $newExports[] = $matches[1];
        }

        continue;
    }

    if (preg_match('/\b(s?_[a-zA-Z0-9_]+)\b/', $line, $matches)) {
        // if (
        //     str_starts_with($matches[1], 'LAB_') ||
        //     str_starts_with($matches[1], 'LP_GEN_') ||
        //     str_starts_with($matches[1], 'caseD') ||
        //     str_starts_with($matches[1], 'switchD')
        // ) {
        //     continue;
        // }

        if (!in_array($matches[1], $exportable, strict: true)) {
            $importable[] = $matches[1];

            if (!in_array($matches[1], $imports)) {
                $newImports[] = $matches[1];
            }
        }

        continue;
    }
}

file_put_contents($filename . '.bak', join($lines));

// $importable = array_filter($importable, fn ($i) => !str_starts_with($i, 'LAB_') && !str_starts_with($i, 'LP_GEN_'));

$imports = array_filter($imports, fn ($i) => in_array($i, $importable));
$exports = array_filter($exports, fn ($i) => in_array($i, $exportable));
$finalImports = array_unique(array_merge($imports, $newImports));
$finalExports = array_unique(array_merge($exports, $newExports));

$finalImports = array_filter($finalImports, fn ($i) => !in_array($i, $finalExports));

$newContent = '';

foreach ($finalImports as $finalImport) {
    $newContent .= "          .IMPORT     $finalImport\r\n";
}

foreach ($finalExports as $finalExport) {
    $newContent .= "          .EXPORT     $finalExport\r\n";
}

if ($sectionPLineIdx === null) {
    $newContent .= "          .SECTION     P, CODE, ALIGN=4\r\n";
}

// Iterate through each line
$sectionPLineIdx ??= 0;
for ($i=$sectionPLineIdx; $i < count($lines); $i++) { 
    $newContent .= $lines[$i];
}

if ($endLineIdx === null) {
    $newContent .= "          .END\r\n";
}

file_put_contents($filename, $newContent);

echo "$filename fixed\n";
