<?php

declare(strict_types=1);

$files = [
    // '_000128_8c010080_main.c',
    // '_003728_8c010e90.c',
    // '_004384_8c011120.c',
    // '_012100_8c012f44.c',
    // '_018740_8c014934.c',
    // '_018864_8c0149b0_sbinit.c',
    // '_019100_8c014a9c_tasks.c',
    // '_019340_8c014b8c_backup.c',
    // '_023224_8c015ab8_title.c',
    // '_024840_8c016108.c',
    // '_027736_8c016c58.c',
    // '_066856_8c020528.c',
    // '_067540_8c0207d4.c',

//     '_000000_8c010000.src',
// '_000188_8c0100bc_sound.src',
// '_004072_8c010fe8_unused.src',
// '_008996_8c012324.src',
// '_009476_8c012504.src',
// '_010700_8c0129cc.src',
// '_012101_data.src',
// '_015080_8c013ae8.src',
// '_020308_8c014f54.src',
// '_024908_8c01614c.src',
// '_027636_8c016bf4.src',
// '_027948_8c016d2c.src',
// '_034372_8c018644.src',
// '_034692_8c018784.src',
// '_037832_8c0193c8.src',
// '_040600_8c019e98.src',
// '_041288_8c01a148.src',
// '_045468_8c01b19c.src',
// '_047944_8c01bb48.src',
// '_051584_8c01c980.src',
// '_053904_8c01d290.src',
// '_055292_8c01d7fc.src',
// '_057980_8c01e27c.src',
// '_062400_8c01f3c0.src',
// '_064120_8c01fa78.src',
// '_066068_8c020214.src',
// '_066964_8c020594.src',
// '_067312_8c0206f0.src',
// '_067612_8c02081c.src',
// '_067860_8c020914.src',
// '_068460_8c020b6c.src',
// '_071452_8c02171c.src',
// '_072604_8c021b9c.src',
// '_074460_8c0222dc.src',
// '_074852_8c022464.src',
// '_076764_8c022bdc.src',
// '_078608_8c023310.src',
// '_080184_8c023938.src',
// '_082220_8c02412c.src',
// '_082560_8c024280.src',
// '_084812_8c024b4c.src',
// '_088176_8c025870.src',
// '_088984_8c025b98.src',
// '_091920_8c026710.src',
// '_096364_8c02786c.src',
// '_096600_8c027958.src',
// '_098904_8c028258.src',
// '_110456_8c02af78.src',
// '_111344_8c02b2f0.src',
// '_111716_8c02b464.src',
// '_116868_8c02c884.src',
// '_118892_8c02d06c.src',
// '_119196_8c02d19c.src',
// '_121192_8c02d968.src',
// '_122684_8c02df3c.src',
// '_123612_8c02e2dc.src',
// '_123904_8c02e400.src',
// '_124188_8c02e51c.src',
// '_127176_8c02f0c8.src',
// '_127776_8c02f320.src',
// '_129872_8c02fb50_sh4nlfzn.src',
// '_143996_8c03327c_strt1_sectionC.src',
// '_144036_8c0332a4_sectionC.src',
// '_179584_8c03bd80_sectionD.src',
// '_259776_8c04f6c0_SDK.src',
// '_970016_8c0fcd20_sectionB.src',

// decompiled
'_004384_8c011120.src',
'_012100_8c012f44.src',
'_023224_8c015ab8_title.src',
'_027736_8c016c58.src',
'_067540_8c0207d4.src',
];

foreach ($files as $file) {
    $isValid = preg_match('/_\d+_[0-9a-fA-F]{8}/', $file);
    $fileNoExt = substr($file, 0, -4);

    if (!$isValid) {
        continue;
    }

    $address = explode('_', $file)[2];
    $address = substr($address, 0, 8);

    $dec = hexdec($address);
    $dec -= 0x8c000000;

    $newDecStr = str_pad((string) $dec, 6, '0', STR_PAD_LEFT);
    $newHexStr = str_pad(dechex($dec), 6, '0', STR_PAD_LEFT);

    $newName = $newHexStr;

    if (preg_match('/^_\d+_[0-9a-fA-F]{8}_([\w_]+).src$/', $file, $matches)) {
        $newName .= "_" . $matches[1];
        //var_dump($matches);
    }

    echo "mv src/asm/decompiled/$file src/asm/decompiled/$newName.src" . PHP_EOL;
    echo "grep -rl '$fileNoExt' src tests build.sh build_matching.sh *.sub run_tests.sh | xargs sed -i 's/$fileNoExt/$newName/g'" . PHP_EOL;

    // Add command to prepend the orignal address in the file for future reference
    echo "echo '; $address' | cat - src/asm/decompiled/$newName.src > temp && mv temp src/asm/decompiled/$newName.src" . PHP_EOL;
}