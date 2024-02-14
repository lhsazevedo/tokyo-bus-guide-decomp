<?php

declare(strict_types=1);

// Naive PHP script used to generate the assembly files with raw bytes

$f = fopen('1ST_READ.BIN', 'r');

$out = '';
$base = 0x8c010000;

function slugify($string) {
    // Remove special characters
    $string = preg_replace('/[^a-zA-Z0-9\s]/', '_', $string);

    // Replace spaces with hyphens
    $string = str_replace(' ', '_', $string);

    // Convert to lowercase
    // $string = strtolower($string);

    // Remove leading and trailing hyphens
    $string = trim($string, '_');

    return $string;
}

$symbols = [
    ['const_sample_bebacafe', 0xbebacafe],
];

$ghidraSymbols = [
    ['DAT_sample_bebacafe', 0xbebacafe],
];

$foundSymbols = [
    ['const_sample_bebacafe', 0xbebacafe],
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

function printHexData($data) {
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
                    $isInvalid = true;
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

    $bytes = unpack('C*', $data);
    $hex = array_map(fn ($i) => strtoupper(dechex($i)), $bytes);
    $padded = array_map(fn ($i) => str_pad($i, 2, '0', STR_PAD_LEFT), $hex);
    $notation = array_map(fn ($i) => "H'" . $i, $padded);
    $split = array_chunk($notation, 16);
    foreach ($split as $chunk) {
        echo '          .DATA.B      ' . join(', ', $chunk) . "\r\n";
    }
}

$addr = 0x8c033538;
fseek($f, $addr - $base);

$shouldBreak = false;
$data = '';

while (!feof($f) && $addr < 0x8c035dd4) {
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
        echo 'const_' . strtolower(dechex($ghidraAddress)) .  ":        ; from ghidra\r\n";
        $data = '';
    } elseif ($k !== false) {
        printHexData($data);
        $foundAddress = $foundSymbols[$k][1];
        echo 'const_' . strtolower(dechex($foundAddress)) .  ":        ; aggressive search\r\n";
        $data = '';
    }

    $data .= fread($f, 1);

    // if (strlen($data) === 16) {
        
    //     printHexLine($data);
    //     $data = '';
    // }

    $addr++;
}

printHexData($data);

