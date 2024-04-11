<?php

$srcFiles = [
    'src/_000000_8c010000.src',
    'src/_000188_8c0100bc_sound.src',
    'src/_004072_8c010fe8_unused.src',
    'src/_004384_8c011120.src',
    'src/_005168_8c011430.src',
    'src/_008160_8c011fe0.src',
    'src/_020308_8c014f54.src',
    'src/_023224_8c015ab8_title.src',
    'src/_024908_8c01614c.src',
    'src/_143996_8c03327c_strt1_sectionC.src',
    'src/_144036_8c0332a4_sectionC.src',
    'src/_179584_8c03bd80_sectionD.src',
    'src/_259776_8c04f6c0_SDK.src',
    'lnk.sub',
];

$symbols = [
    '__bebacafe',
];

$replacements = [
    'var_bebacafe',
];

foreach ($srcFiles as $name) {
    file_put_contents($name, str_replace($symbols, $replacements, file_get_contents($name)));
}
