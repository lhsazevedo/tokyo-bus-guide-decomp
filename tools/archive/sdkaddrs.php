<?php

$sdkAddrs = file('sdkaddrs.txt');
$myAddrs = file('mysdkaddrs.txt');

foreach ($myAddrs as $ma) {
    foreach ($sdkAddrs as $sa) {
        if (str_starts_with($sa, trim($ma))) {
            $symbol = explode("\t", trim($sa))[1];
            $addr = trim($ma);
            echo "sed -i \"s/__$addr/$symbol/g\" lnk.sub\n";
        }
    }
}
