<?php


$symbols = [
    ['_var_8c0fcd38', 0x8C0FCD38],
    ['_var_8c0fcd3c', 0x8C0FCD3C],
    ['_var_8c157a5c', 0x8C157A5C],
    ['_var_8c157a60', 0x8C157A60],
    ['_var_seed_8c157a64', 0x8C157A64],
    ['_var_8c157a68', 0x8C157A68],
    ['_var_8c157a6c', 0x8C157A6C],
    ['_var_8c157a70', 0x8C157A70],
    ['_var_8c157a74', 0x8C157A74],
    ['_var_8c157a78', 0x8C157A78],
    ['_var_8c157a7c', 0x8C157A7C],
    ['__8c157a80_basedir', 0x8C157A80],
    ['_var_8c157a84', 0x8C157A84],
    ['_var_8c157a88', 0x8C157A88],
    ['__8c157a8c_start', 0x8C157A8C],
    ['__8c157a90_current', 0x8C157A90],
    ['__8c157a94_end', 0x8C157A94],
    ['_var_8c157a98', 0x8C157A98],
    ['_queuedNjFiles_8c157a9c', 0x8C157A9C],
    ['_queuedNjFilesCursor_8c157aa0', 0x8C157AA0],
    ['_queuedNjFilesEnd_8c157aa4', 0x8C157AA4],
];

for ($i=0; $i < count($symbols); $i++) { 
    if (!isset($symbols[$i+1])) {
        exit('done.' . PHP_EOL);
    }

    echo $symbols[$i][0] . ":\r\n";
    echo "          .RES.B      " . $symbols[$i + 1][1] - $symbols[$i][1] . "\r\n";
}
