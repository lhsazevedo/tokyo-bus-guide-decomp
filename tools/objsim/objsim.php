<?php

declare(strict_types=1);

function dd(...$args) {
    var_dump(...$args);
    exit;
}

$magic = "\x80\x21\x00\x80\x00\x80\x80\x80\x00\x80\x80\x80\x80\x80\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00";

$obj = file_get_contents("./build/_023224_8c015ab8_title.obj");

if (substr($obj, 0, 0x20) !== $magic) {
    echo "Invalid magic.\n";
    exit;
}

$offset = 0x20;

enum ChunkType {
    case ModuleHeader;
    case UnitHeader;
    case UnitDebug;
    case Section;
    case Imports;
    case Exports;
    case SectionSelection;
    case ObjectData;
    case Relocation;
    case End;
    case Uknown;
}

class Chunk {
    public ChunkType $type;
    public bool $continuation;

    public function __construct(
        public int $ukn,
        int $type,
        public int $len
    ) {
        $this->continuation = ($type & 0x80) === 1;

        $this->type = match ($type & 0x7f) {
            0x04 => ChunkType::ModuleHeader,
            0x06 => ChunkType::UnitHeader,
            0x07 => ChunkType::UnitDebug,
            0x08 => ChunkType::Section,
            0x0c => ChunkType::Imports,
            0x14 => ChunkType::Exports,
            0x1a => ChunkType::SectionSelection,
            0x1c => ChunkType::ObjectData,
            0x20 => ChunkType::Relocation,
            0x7f => ChunkType::End,
            default => ChunkType::Uknown,
        };
    }
}

$chunks = [];

while ($offset < strlen($obj)) {
    $chunkBase = $offset;

    if ($obj[$offset] === "\xfd") {
        dd("File end?");
    }

    $ukn = ord($obj[$chunkBase]);
    $type = ord($obj[$chunkBase + 1]);
    $len = ord($obj[$chunkBase + 2]);

    $ctype = null;

    $chunk = new Chunk($ukn, $type, $len);
    $chunks[] = $chunk;

    var_dump($chunk->type);

    switch ($chunk->type) {
        case ChunkType::ModuleHeader:
            # code...
            break;
        
        default:
            # code...
            break;
    }

    $offset += $len;
}
