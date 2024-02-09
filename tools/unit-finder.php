<?php

declare(strict_types=1);


function dd(...$args) {
    var_dump(...$args);
    exit;
}

class Directive
{
    public function __construct(
        public string $name,
        public ?string $value,
        public string $file,
        public int $lineNo,
    ) { }
}

class Symbol {
    public function __construct(
        public string $name,
    ) { }

    public function getHexAddress(): string
    {
        $hex = substr($this->name, -8);
        $addr = hexdec($hex);
        if (!$addr || ($addr < 0x8c010000 || $addr > 0x8c0f0000)) {
            throw new Exception("Strange address $hex", 1);
        }

        return $hex;
    }

    public function getAddress() {
        return hexdec($this->getHexAddress());
    }
}

abstract class SymbolDefinition extends Symbol
{
    public function __construct(
        string $name,
        public string $file,
        public int $lineIdx,
    ) {
        parent::__construct($name);
    }
}

class LabelSymbol extends SymbolDefinition
{

}

class FunctionSymbol extends SymbolDefinition
{
    public ?string $inUnit = null;
    public ?bool $unitBefore = false;
    public ?bool $unitAfter = false;
}

class Instruction
{
    public function __construct(
        public string $name,
        /* @var string[] */
        public ?array $operands,
        public string $file,
        public int $lineIdx,
    ) { }
}

function validate_symbol($name) {
    $hex = substr($name, -8);

    if (!preg_match('/[0-9A-F]{8}/i', $hex)) return false;

    $addr = hexdec($hex);
    if (!$addr || ($addr < 0x8c010000 || $addr > 0x8c0f0000)) return false;

    return true;
}

$file = 'src/asm/_012100_8c012f44.src';

$lines = file($file);
// $lines = array_map('rtrim');

$items = [];

foreach ($lines as $lineIdx => $line) {
    $trimmed = rtrim($line);

    if (preg_match('/^\s*(;.*)?$/', $trimmed)) {
        continue;
    }

    if (preg_match('/^([a-zA-Z_][a-zA-Z0-9_]+):/', $trimmed, $matches)) {
        [, $symbolName] = $matches;

        if (str_starts_with($symbolName, 'LAB') ||
            str_starts_with($symbolName, 'LP_GEN_') ||
            str_starts_with($symbolName, 'caseD') ||
            str_starts_with($symbolName, 'switchD') ||
            preg_match('/^L\d+$/', $symbolName)) {
            $items[] = new LabelSymbol(
                $symbolName,
                $file,
                $lineIdx,
            );
        } else {
            // if (!str_starts_with($symbolName, '_FUN_')) {
            //     var_dump($symbolName);
            // }
            $items[] = new FunctionSymbol(
                $symbolName,
                $file,
                $lineIdx,
            );
        }
        // } elseif (str_starts_with($symbolName, '_FUN_')) {
        //     $items[] = new LabelSymbol(
        //         $symbolName,
        //         $file,
        //         $lineIdx,
        //     );
        // }
        // } else {
        //     throw new Exception("Unknown symbol type $symbolName\n", 1);
        // }

        continue;
    }

    if (preg_match('/^\s+(\.[A-Z]+(\.[BWL])?)(?:\s+(.*))?/', $trimmed, $matches, PREG_UNMATCHED_AS_NULL)) {
        [, $directiveName, , $directiveValue] = $matches;
        $items[] = new Directive(
            $directiveName,
            $directiveValue,
            $file,
            $lineIdx,
        );

        continue;
    }

    if (preg_match('/^\s+([A-Z]+(\.[BWL])?)(\s+(.*))?/', $trimmed, $matches, PREG_UNMATCHED_AS_NULL)) {
        [, $instructionName, $sizeModifier, , $operands] = $matches;

        $items[] = new Instruction(
            $instructionName,
            $operands ? array_map('trim', explode(',', $operands)) : null,
            $file,
            $lineIdx,
        );  

        continue;
    }

    echo 'FATAL: Unsupported line: ' . PHP_EOL;
    var_dump($line);
    die;
}

function fixItems(FunctionSymbol $innerItem, FunctionSymbol $targetFunction) {
    global $items;

    foreach (array_filter($items, fn ($itemBeingFixed) => $itemBeingFixed instanceof FunctionSymbol) as $functionBeingFixed) {
        if ($functionBeingFixed->inUnit === $innerItem->inUnit) {
            $functionBeingFixed->inUnit = $targetFunction->inUnit;
        }
    }
}

function findPreviousFunction($idx) {
    global $items;

    $targetFunctionIdx = null;
    for ($i=$idx; $i > 0; $i--) { 
        $innerItem = $items[$i];
        if (!($innerItem instanceof FunctionSymbol)) continue;

        $targetFunctionIdx = $i;
        break;
    }

    return $targetFunctionIdx;
}

/*
O que pode conectar FUN??ES?
- BSR
- Refer?ncias para labels (DATA)
- Alinhamento
*/

$ranges = [];

/* - Alinhamento */
echo "Alinhamento\n";
$alignCount = 0;
foreach ($items as $item) {
    if ($item instanceof FunctionSymbol && ($item->getAddress() & 0x03) !== 0) {
        $item->unitBefore = true;
    }
}

/* - BSR/BRA */

echo "BSR/BRA\n";
$bsrCount = 0;
foreach ($items as $bsrIdx => $item) {
    if ($item instanceof Instruction && in_array($item->name, ['BSR', 'BRA'], strict: true)) {
        $target = $item->operands[0];

        // if (str_starts_with($target, 'LAB_')) continue;

        if (!validate_symbol($target)) {
            throw new Exception("Strange BSR target: $target", 1);
        }

        // $targetSymbol = new Symbol($target);

        $found = false;
        $targetIdx = null;
        foreach ($items as $innerKey => $innerItem) {
            if (!($innerItem instanceof Symbol)) continue;

            if ($innerItem->name !== $target) continue;

            $found = true;
            $targetIdx = $innerKey;
            break;
        }

        if (!$found) {
            continue;
            // throw new Exception("Symbol not found: $target", 1)
        }

        $reverse = $targetIdx > $bsrIdx;

        $bsrFunctionIdx = findPreviousFunction($bsrIdx);
        if (!$bsrFunctionIdx) throw new Exception("$item->name intruction without function", 1);
        $bsrFunction = $items[$bsrFunctionIdx];

        $targetFunctionIdx = findPreviousFunction($targetIdx);
        if (!$targetFunctionIdx) throw new Exception("Target without function $target", 1);
        $targetFunction = $items[$targetFunctionIdx];

        // if ($bsrFunctionIdx === $targetFunctionIdx) throw new Exception("BSR and target are in the same function: $bsrFunction->name -> $target", 1);

        // $bsrFunction->inUnit ??= random_bytes(40);

        if ($bsrFunctionIdx === $targetFunctionIdx) continue;

        echo "- $item->name $target\n";

        $ranges[] = $reverse
            ? [$bsrFunctionIdx, $targetFunctionIdx]
            : [$targetFunctionIdx, $bsrFunctionIdx];

        // for (
        //     $i = !$reverse ? $targetFunctionIdx + 1 : $targetFunctionIdx - 1;
        //     !$reverse ? $i <= $bsrIdx : $i >= $bsrIdx;
        //     $i += !$reverse ? 1 : -1
        // ) { 
        //     $innerItem = $items[$i];

        //     if (!($innerItem instanceof FunctionSymbol)) continue;

        //     if (!$innerItem->inUnit) {
        //         $innerItem->inUnit = $bsrFunction->inUnit;
        //         $bsrCount++;
        //         continue;
        //     }

        //     fixItems($innerItem, $bsrFunction);
        //     $bsrCount++;
        // }
    }
}


/* - Referencias para labels (DATA) */

// $doneRefs = [];

echo "Referencias para labels (DATA)\n";
$refCount = 0;
foreach ($items as $instIdx => $item) {
    if (!($item instanceof Instruction) || empty($item->operands)) {
        continue;
    }

    if (!str_starts_with($item->name, 'MOV')) continue;

    $operands = array_map(fn ($op) => preg_replace('/(\w+)\+\d+/', '\1', $op), $item->operands);
    $targets = array_filter($operands, fn ($op) => preg_match('/^\w{5,}$/', $op));
    // $targets = $operands;
    if (empty($targets)) continue;
    if (count($targets) > 1) {
        var_dump($targets);
        throw new Exception("what", 1);
    }

    $target = $targets[0];

    if (str_starts_with($target, 'LAB_')) continue;

    // if (in_array($target, $doneRefs)) continue;

    $found = false;
    $targetIdx = null;
    foreach ($items as $innerKey => $innerItem) {
        if (!($innerItem instanceof SymbolDefinition)) continue;

        if ($innerItem->name !== $target) continue;

        $found = true;
        $targetIdx = $innerKey;
        break;
    }

    if (!$found) throw new Exception("Symbol not found: $target", 1);

    $reverse = $targetIdx < $instIdx;
    if ($reverse) throw new Exception("Unexpected backwards data ref. $target from item at $item->lineIdx");

    echo "- $item->name $target\n";

    $instrFunctionIdx = findPreviousFunction($instIdx);
    if (!$instrFunctionIdx) throw new Exception("Intruction without function $item->name", 1);
    $instrFunction = $items[$instrFunctionIdx];

    $targetFunctionIdx = findPreviousFunction($targetIdx);
    if (!$targetFunctionIdx) throw new Exception("Target without function $target", 1);
    $targetFunction = $items[$targetFunctionIdx];

    if ($instrFunctionIdx === $targetFunctionIdx) continue;

    $ranges[] = [$instrFunctionIdx, $targetFunctionIdx];

    $instrFunction->unitAfter = true;
    for ($i=$instrFunctionIdx+1; $i < $targetFunctionIdx; $i++) { 
        $innerItem = $items[$i];

        if (!($innerItem instanceof FunctionSymbol)) continue;

        $innerItem->unitBefore = true;
        $innerItem->unitAfter = true;
    }
    $targetFunction->unitBefore = true;

    // $doneRefs[] = $target;
}

echo "FOI!\n";

foreach ($ranges as $range) {
    if ($range[0] >= $range[1]) {
        print_r($range);
        throw new Exception("Strange range", 1);
    }
}

foreach ($items as $itemIdx => $item) {
    if (!($item instanceof FunctionSymbol)) continue;

    if ($item->unitBefore && $item->unitAfter) continue;

    if (!$item->unitAfter) {
        foreach ($ranges as $range) {
            if ($itemIdx >= $range[0] && $itemIdx < $range[1]) {
                $item->unitAfter = true;

                break;
            }
        }
    }

    if (!$item->unitBefore) {
        foreach ($ranges as $range) {
            if ($itemIdx <= $range[1] && $itemIdx > $range[0]) {
                $item->unitBefore = true;

                break;
            }
        }
    }
}

$functions = array_values(array_filter($items, fn ($i) => $i instanceof FunctionSymbol));

for ($i=0; $i < count($functions) - 1; $i++) {
    $funcA = $functions[$i];
    $funcB = $functions[$i + 1];

    if ($funcA->unitAfter) {
        echo "Fixing $funcB->name\n";
        $funcB->unitBefore = true;
    } elseif ($funcB->unitBefore) {
        echo "Fixing $funcA->name\n";
        $funcA->unitAfter = true;
    }
}

foreach ($items as $itemIdx => $item) {
    if (!($item instanceof FunctionSymbol)) continue;

    echo str_pad($item->name, 40);

    if ($item->unitBefore) {
        echo '.';
    } else {
        echo '<';
    }

    if ($item->unitAfter) {
        echo '.';
    } else {
        echo '>';
    }

    echo "\n";
}

// $lastItemUnit = null;
// foreach (array_filter($items, fn ($i) => $i instanceof FunctionSymbol) as $i) {
//     if ($i->inUnit) {
//         $hex = bin2hex($i->inUnit);
//     } else {
//         $hex = 'none';
//     }
//     echo $i->name . ' ' . $hex . "\n";
//     // if ($i->inUnit !== $lastItemUnit) {
//     //     $lastItemUnit = $i->inUnit;
//     //     echo "- " . $i->name . "\n";
//     // }
// }

// var_dump(compact('alignCount', 'bsrCount', 'refCount'));
