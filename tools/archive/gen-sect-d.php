<?php

declare(strict_types=1);

// Naive PHP script used to generate the assembly files with raw bytes

$f = fopen('1ST_READ.BIN', 'r');

function dd(...$args) {
    var_dump(...$args);
    exit;
}

$out = '';
$base = 0x8c010000;

$symbols = [
    ['init_sample_bebacafe', 0xbebacafe],
];

$ghidraSymbols = [
    ['init_sample_bebacafe', 0xbebacafe],
];

$foundSymbols = [
    ['init_sample_bebacafe', 0xbebacafe],
    
];

function isShiftJIS($string) {
    // Check if the string is empty
    if (empty($string)) {
        return false;
    }

    // Iterate through each character in the string
    for ($i = 0; $i < strlen($string); $i++) {
        $byte = ord($string[$i]);

        // Check for valid Shift JIS character ranges
        if (
            ($byte >= 0x81 && $byte <= 0x9F) ||
            ($byte >= 0xE0 && $byte <= 0xFC)
        ) {
            // Check for valid second byte
            $i++;
            if ($i < strlen($string)) {
                $secondByte = ord($string[$i]);
                if (($secondByte >= 0x40 && $secondByte <= 0x7E) || ($secondByte >= 0x80 && $secondByte <= 0xFC)) {
                    continue;
                } else {
                    return false;
                }
            } else {
                return false; // Incomplete character at the end of the string
            }
        } elseif ($byte === 0x8E) {
            // Hankaku Kana (half-width katakana) is a valid Shift JIS character
            $i++;
        } elseif ($byte >= 0xA1 && $byte <= 0xDF) {
            // Hankaku Kana (half-width katakana) is a valid Shift JIS character
            continue;
        } elseif ($byte >= 0x20 && $byte < 0x7F) {
            // Non control ASCII is a valid Shift JIS character
            continue;
        } else {
            return false; // Invalid character
        }
    }

    return true;
}

function filterNullBytes($value) {
    return ctype_xdigit(bin2hex($value));
}

function strpos_all($haystack, $needle) {
    $positions = array();
    $pos = 0;

    while (($pos = strpos($haystack, $needle, $pos)) !== false) {
        $positions[] = $pos;
        $pos = $pos + strlen($needle);
    }

    return $positions;
}

function printHexData($data) {
    global $symbols;
    global $ghidraSymbols;
    global $foundSymbols;

    if (empty($data)) return;

    $dataLen = strlen($data);
    $trimmed = rtrim($data, "\0");

    if (
        $dataLen > 4
        && mb_detect_encoding($data, 'SJIS', true) === 'SJIS'
    ) {
        $trailingNullBytes = strlen($data) - strlen($trimmed);

        if (substr_count($trimmed, "\0") !== 0) {
            $lines = '';
            $isInvalid = false;
            $start = 0;
            while ($start < $dataLen) {
                $arrayTrailingNullBytes = 0;
                // while ($data[$start] === "\0") $start++;
                $nullPos = strpos($data, "\0", $start);
                $substr = substr($data, $start, $nullPos - $start);
                if (!isShiftJIS($substr)) {
                    break;
                }
                $lines .= '          ;.SDATA      "' . $substr . "\"\r\n";
                $lines .= "          ;.DATA.B     H'00\r\n";

                while (
                    (($nullPos + $arrayTrailingNullBytes) < $dataLen)
                    && $data[$nullPos + $arrayTrailingNullBytes] === "\0"
                ) {
                    $arrayTrailingNullBytes++;
                }

                $start = $nullPos + $arrayTrailingNullBytes;

                if ($arrayTrailingNullBytes > 1) {
                    $lines .= '          ;.RES.B      ' . $arrayTrailingNullBytes - 1 . "\r\n";
                }
            }

            if (!$isInvalid) {
                echo $lines;
            }
        } elseif (
            strlen($trimmed) > 4
            && $trailingNullBytes <=5
            && substr_count($trimmed, "\0") === 0
            && isShiftJIS($trimmed)
        ) {
            echo '          ;.SDATA      "' . $trimmed . "\"\r\n";
            echo "          ;.DATA.B     H'00\r\n";

            if ($trailingNullBytes > 1) {
                echo '          ;.RES.B      ' . $trailingNullBytes - 1 . "\r\n";
            }
            // return;
        }
    }

    $ptrOffsets = [];
    $matches = strpos_all($data, "\x8c");
    // preg_match_all('/(...\x8c)/m', $data, $matches, PREG_OFFSET_CAPTURE);
    foreach ($matches as $match) {
        if ($match < 3 ) {
            continue;
        }
        $dec = unpack('V', substr($data, $match-3, 4))[1];
        // dd(dechex($dec));
        if (($dec >= 0x8c010000) && ($dec < 0x8C2F90A0)) {
            $ptrOffsets[] = $match-3;
        }
    }

    $bytes = unpack('C*', $data);

    $bytesAndSymbols = [];

    for ($i=0; $i < $dataLen; $i++) {
        if (in_array($i, $ptrOffsets)) {
            $offset = $i;
            $dec = unpack('V', substr($data, $offset, 4))[1];
            
            $s = array_search($dec, array_column($symbols, 1), true);
            $g = array_search($dec, array_column($ghidraSymbols, 1), true);
            $f = array_search($dec, array_column($foundSymbols, 1), true);
            if ($s !== false) {
                $bytesAndSymbols[] = $symbols[$s][0];
            } elseif ($g !== false) {
                $bytesAndSymbols[] = $ghidraSymbols[$g][0];
            } elseif ($f !== false) {
                $bytesAndSymbols[] = $foundSymbols[$f][0];
            } else {
                if ($dec >= 0x8c03327c && $dec < 0x8C03BD80) {
                    $bytesAndSymbols[] = '_const_' . dechex($dec) . ' ; ukn'; 
                } elseif ($dec >= 0x8C03BD80 && $dec < 0x8c04f6c0) {
                    $bytesAndSymbols[] = '_init_' . dechex($dec) . ' ; ukn'; 
                } elseif ($dec >= 0x8c0fcd20 && $dec < 0x8C2F90A0) {
                    $bytesAndSymbols[] = '_var_' . dechex($dec) . ' ; ukn'; 
                } else {
                    $bytesAndSymbols[] = '__' . dechex($dec) . ' ; ukn'; 
                }

                // die('Unkown symbol at ' . );
            }

            $i += 3;
        } else {
            $bytesAndSymbols[] = $bytes[$i+1];
        }
    }

    $bytesSinceLastSymbol = [];
    for ($i=0; $i < count($bytesAndSymbols); $i++) {
        $bs = $bytesAndSymbols[$i];

        if (is_int($bs)) {
            $bytesSinceLastSymbol[] = $bs;
        }

        if ($i === count($bytesAndSymbols) - 1 || is_string($bs)) {
            $hex = array_map(fn ($i) => strtoupper(dechex($i)), $bytesSinceLastSymbol);
            $padded = array_map(fn ($i) => str_pad($i, 2, '0', STR_PAD_LEFT), $hex);
            $notation = array_map(fn ($i) => "H'" . $i, $padded);
            $split = array_chunk($notation, 16);
            foreach ($split as $chunk) {
                echo '          .DATA.B      ' . join(', ', $chunk) . "\r\n";
            }

            $bytesSinceLastSymbol = [];
        }

        if (is_string($bs)) {
            echo '          .DATA.L      ' . $bs . "\r\n";
        }
    }
}

$addr = 0x8c03be80;
fseek($f, $addr - $base);

$shouldBreak = false;
$data = '';

while (!feof($f) && $addr < 0x8c04411c) {
    $i = array_search($addr, array_column($symbols, 1), true);
    $j = array_search($addr, array_column($ghidraSymbols, 1), true);
    $k = array_search($addr, array_column($foundSymbols, 1), true);
    if ($i !== false) {
        printHexData($data);
        echo $symbols[$i][0] .  ":        ; from defines\r\n";
        $data = '';
    } elseif ($j !== false) {
        printHexData($data);
        $ghidraAddress = $ghidraSymbols[$j][1];
        echo 'init_' . strtolower(dechex($ghidraAddress)) .  ":        ; from ghidra\r\n";
        $data = '';
    } elseif ($k !== false) {
        printHexData($data);
        $foundAddress = $foundSymbols[$k][1];
        echo 'init_' . strtolower(dechex($foundAddress)) .  ":        ; aggressive search\r\n";
        $data = '';
    }

    $data .= fread($f, 1);

    $addr++;
}

printHexData($data);

