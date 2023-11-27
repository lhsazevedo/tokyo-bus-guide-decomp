<?php

declare(strict_types=1);

class Symbol {
    public function __construct(
        public string $name,
        public string $address,
        public ?string $definedIn = null,
        public bool $exported = false
    ) { }
}

class Definition {
    public function __construct(
        public string $name,
        public string $address,
    ) { }
}

$srcFiles = [
    'src/_000000_8c010000.src' => file_get_contents('src/_000000_8c010000.src'),
    'src/_000188_8c0100bc_sound.src' => file_get_contents('src/_000188_8c0100bc_sound.src'),
    'src/_004072_8c010fe8.src' => file_get_contents('src/_004072_8c010fe8.src'),
    'src/_004384_8c011120.src' => file_get_contents('src/_004384_8c011120.src'),
    'src/_005168_8c011430.src' => file_get_contents('src/_005168_8c011430.src'),
    'src/_008160_8c011fe0.src' => file_get_contents('src/_008160_8c011fe0.src'),
    'src/_020308_8c014f54.src' => file_get_contents('src/_020308_8c014f54.src'),
    'src/_023224_8c015ab8_title.src' => file_get_contents('src/_023224_8c015ab8_title.src'),
    'src/_024908_8c01614c.src' => file_get_contents('src/_024908_8c01614c.src'),
    'src/_143996_8c03327c_strt1_sectionC.src' => file_get_contents('src/_143996_8c03327c_strt1_sectionC.src'),
    'src/_144036_8c0332a4_sectionC.src' => file_get_contents('src/_144036_8c0332a4_sectionC.src'),
    'src/_179584_8c03bd80_sectionD.src' => file_get_contents('src/_179584_8c03bd80_sectionD.src'),
    'src/_259776_8c04f6c0_SDK.src' => file_get_contents('src/_259776_8c04f6c0_SDK.src'),
];

$lnkContent = file_get_contents('lnk.sub');

/** @var Definition[] */
$defines = [];
preg_match_all('/^define ([a-zA-Z0-9_]+)\(([a-fA-F0-9]+)\)/m', $lnkContent, $matches, PREG_SET_ORDER);
foreach ($matches as $m) {
    $defines[] = new Definition($m[1], strtolower($m[2]));
}

/** @var Symbol[] */
$symbols = [];
foreach ($srcFiles as $f => $content) {
    preg_match_all('/([a-zA-Z0-9_]+_([a-fA-F0-9]{8})):/m', $content, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $exported = preg_match('/\.EXPORT\s+' . $m[1] . '/m', $content) === 1;
        $symbols[] = new Symbol($m[1], strtolower($m[2]), $f, $exported);
    }
}

$count = 0;

foreach ($symbols as $symbol) {
    foreach ($defines as $define) {
        if ($symbol->address === $define->address) {
            $count++;
            echo str_pad($symbol->name, 40);
            echo $symbol->exported ? "✔ " : "✖  ";
            if ($symbol->name !== $define->name) {
                echo "$define->name";
            }
            echo "\n";

            // Add missing export
            if (!$symbol->exported) {
                $c = explode("\r\n", $srcFiles[$symbol->definedIn]);
                $sectLine = -1;
                foreach ($c as $ci => $cl) {
                    if (preg_match('/\s+\.SECTION/', $cl)) {
                        $sectLine = $ci;
                        break;
                    }
                }

                if ($sectLine === -1) {
                    exit("SECTION not found\n");
                }

                echo "- Adding export to $symbol->definedIn at line $sectLine\n";
                array_splice($c, $sectLine, 0, "          .EXPORT     $symbol->name");
                $srcFiles[$symbol->definedIn] = join("\r\n", $c);
            }

            // Renomear ocorrências do define
            if ($symbol->name !== $define->name) {
                foreach ($srcFiles as $file => $content) {
                    echo "- Fixing in $file\n";
                    $count = 0;
                    $srcFiles[$file] = preg_replace("/\b$define->name\b/", $symbol->name, $content, -1, $count);
                }
            }

            // Apagar define;
            echo "- Removing define\n";
            $count = 0;
            $lnkContent = preg_replace('/define ' . $define->name . '\(........\)\r\n/', "", $lnkContent, -1, $count);

            if ($count <= 0) {
                echo "Failed to remove define\n";
                exit;
            }

            continue 2;
        }
    }
}

file_put_contents('./lnk.sub', $lnkContent);
foreach ($srcFiles as $file => $content) {
    file_put_contents($file, $content);
}
