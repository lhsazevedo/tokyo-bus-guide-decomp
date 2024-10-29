<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Types\U32;

function fdec(float $value) {
    return unpack('L', pack('f', $value))[1];
}

return new class extends TestCase {
    public function test_skips_when_no_text()
    {
        $this->resolveSymbols();

        // $WIDTH = 0x240;
        // $HEIGHT = 0x40;

        // $glyphIndexes = $this->alloc(4);
        $box = $this->alloc(0x3c);
        // $this->initUint32($box + 0x0c, $WIDTH);
        // $this->initUint32($box + 0x10, $HEIGHT);
        // $this->initUint32($box + 0x2c, $glyphIndexes);
        // $lineOffsets = $this->alloc((int) ($HEIGHT * 4 / 32));
        // $this->initUint32($box + 0x34, $lineOffsets);
        $this->initUint32($box + 0x38, 0);
        // $this->initUint16($glyphIndexes, -1);

        $this->call('_menuTextboxTextSub_8c0155e0')
            ->with($box)
            ->shouldReturn(0)
            ->run();
    }

    public function test_skips_when_text_is_empty()
    {
        $this->resolveSymbols();

        // $WIDTH = 0x240;
        // $HEIGHT = 0x40;

        // $glyphIndexes = $this->alloc(4);
        $text = $this->allocString('');
        $box = $this->alloc(0x3c);
        // $this->initUint32($box + 0x0c, $WIDTH);
        // $this->initUint32($box + 0x10, $HEIGHT);
        // $this->initUint32($box + 0x2c, $glyphIndexes);
        // $lineOffsets = $this->alloc((int) ($HEIGHT * 4 / 32));
        // $this->initUint32($box + 0x34, $lineOffsets);
        $this->initUint32($box + 0x38, $text);
        // $this->initUint16($glyphIndexes, -1);

        $this->call('_menuTextboxTextSub_8c0155e0')
            ->with($box)
            ->shouldReturn(0)
            ->run();
    }

    public function test_it_loads_glyphs()
    {
        $this->resolveSymbols();

        $WIDTH = 0x240;
        $HEIGHT = 0x40;

        $var_8c1bc7a0 = $this->alloc(0x200 * 2);
        $this->initUint16Array($var_8c1bc7a0, array_fill(0, 0x200, 0xffff));
        $this->initUint32($this->addressOf('_var_8c1bc7a0'), $var_8c1bc7a0);

        $var_glyphTexnames_8c1bc78c = $this->alloc(0x200 * 0x0c);
        // $this->initUint16Array($var_glyphTexnames_8c1bc78c, array_fill(0, 0x200, 0xffff));
        $this->initUint32($this->addressOf('_var_glyphTexnames_8c1bc78c'), $var_glyphTexnames_8c1bc78c);

        $var_glyphTexlists_8c1bc790 = $this->alloc(0x200 * 0x8);
        // $this->initUint16Array($var_glyphTexlists_8c1bc790, array_fill(0, 0x200, 0xffff));
        $this->initUint32($this->addressOf('_var_glyphTexlists_8c1bc790'), $var_glyphTexlists_8c1bc790);

        $this->initUint32($this->addressOf('_var_busFont_8c1ba1c8'), 0xcafe0001);
        $this->initUint32($this->addressOf('_var_glyphBuffer_8c1bc7a4'), 0xcafe0002);

        $text = $this->allocString('‚‚‚‚ƒ');
        $box = $this->alloc(0x3c);
        $this->initUint32($box + 0x00, 0); // x
        $this->initUint32($box + 0x04, 500); // y
        $this->initUint32($box + 0x08, fdec(42)); // priority
        $this->initUint32($box + 0x0c, $WIDTH); // width
        $this->initUint32($box + 0x10, $HEIGHT); // height
        $this->initUint32($box + 0x14, 0);
        $this->initUint32($box + 0x18, 0);
        $this->initUint16($box + 0x1c, 0); // processed_char_count_0x1c
        $this->initUint16($box + 0x1e, 0); // processed_tag_count_0x1e
        $this->initUint16($box + 0x20, 3); // character_count_0x20
        $this->initUint16($box + 0x22, 0); // tag_count_0x22
        $glyphIndexes = $this->alloc(3 * 2);
        $this->initUint32($box + 0x2c, $glyphIndexes);
        $this->initUint32($box + 0x30, -1);
        $lineOffsets = $this->alloc((int) ($HEIGHT * 4 / 32));
        $this->initUint32Array($lineOffsets, array_fill(0, (int) ($HEIGHT * 4 / 32), fdec(0)));
        $this->initUint32($box + 0x34, $lineOffsets);
        $this->initUint32($box + 0x38, $text);

        $shouldLoadGlyphContext = [
            "box" => $box,
            "var_glyphTexnames_8c1bc78c" => $var_glyphTexnames_8c1bc78c,
            "var_glyphTexlists_8c1bc790" => $var_glyphTexlists_8c1bc790,
            "var_8c1bc7a0" => $var_8c1bc7a0,
            "glyphIndexes" => $glyphIndexes,
        ];

        $shouldDrawCharacterContext = [
            "box" => $box,
            "var_glyphTexlists_8c1bc790" => $var_glyphTexlists_8c1bc790,
        ];

        // Load and draw ‚
        $this->shouldLoadGlyph(
            ...$shouldLoadGlyphContext,
            charCode:              0x8281,
            glyphIndex:            0,
            newProcessedCharCount: 1,
        );
        $this->shouldDrawCharacter(
            ...$shouldDrawCharacterContext,
            glyphIndex: 0,
            x:          0.0,
            y:          500.0,
            priority:   42.0,
        );

        // Load and draw ‚‚
        $this->shouldLoadGlyph(
            ...$shouldLoadGlyphContext,
            charCode:              0x8282,
            glyphIndex:            1,
            newProcessedCharCount: 2
        );
        $this->shouldDrawCharacter(
            ...$shouldDrawCharacterContext,
            glyphIndex: 1,
            x:          24.0,
            y:          500.0,
            priority:   42.0,
        );

        // Load and draw ‚ƒ
        $this->shouldLoadGlyph(
            ...$shouldLoadGlyphContext,
            charCode:              0x8283,
            glyphIndex:            2,
            newProcessedCharCount: 3
        );
        $this->shouldDrawCharacter(
            ...$shouldDrawCharacterContext,
            glyphIndex: 2,
            x:          48.0,
            y:          500.0,
            priority:   42.0,
        );

        $this->call('_menuTextboxTextSub_8c0155e0')
            ->with($box, 3)
            ->shouldReturn(1)
            ->run();
    }

    public function test_it_reloads_already_loaded_glyphs()
    {
        $this->resolveSymbols();

        $WIDTH = 0x240;
        $HEIGHT = 0x40;

        $var_8c1bc7a0 = $this->alloc(0x200 * 2);
        $this->initUint16Array($var_8c1bc7a0, array_fill(0, 0x200, 0xffff));
        $this->initUint32($this->addressOf('_var_8c1bc7a0'), $var_8c1bc7a0);

        $var_glyphTexnames_8c1bc78c = $this->alloc(0x200 * 0x0c);
        // $this->initUint16Array($var_glyphTexnames_8c1bc78c, array_fill(0, 0x200, 0xffff));
        $this->initUint32($this->addressOf('_var_glyphTexnames_8c1bc78c'), $var_glyphTexnames_8c1bc78c);

        $var_glyphTexlists_8c1bc790 = $this->alloc(0x200 * 0x8);
        // $this->initUint16Array($var_glyphTexlists_8c1bc790, array_fill(0, 0x200, 0xffff));
        $this->initUint32($this->addressOf('_var_glyphTexlists_8c1bc790'), $var_glyphTexlists_8c1bc790);

        $this->initUint32($this->addressOf('_var_busFont_8c1ba1c8'), 0xcafe0001);
        $this->initUint32($this->addressOf('_var_glyphBuffer_8c1bc7a4'), 0xcafe0002);

        $text = $this->allocString('‚‚‚‚');
        $box = $this->alloc(0x3c);
        $this->initUint32($box + 0x00, 0); // x
        $this->initUint32($box + 0x04, 500); // y
        $this->initUint32($box + 0x08, fdec(42)); // priority
        $this->initUint32($box + 0x0c, $WIDTH); // width
        $this->initUint32($box + 0x10, $HEIGHT); // height
        $this->initUint32($box + 0x14, 0);
        $this->initUint32($box + 0x18, 0);
        $this->initUint16($box + 0x1c, 0); // processed_char_count_0x1c
        $this->initUint16($box + 0x1e, 0); // processed_tag_count_0x1e
        $this->initUint16($box + 0x20, 3); // character_count_0x20
        $this->initUint16($box + 0x22, 0); // tag_count_0x22
        $glyphIndexes = $this->alloc(3 * 2);
        $this->initUint32($box + 0x2c, $glyphIndexes);
        $this->initUint32($box + 0x30, -1);
        $lineOffsets = $this->alloc((int) ($HEIGHT * 4 / 32));
        $this->initUint32Array($lineOffsets, array_fill(0, (int) ($HEIGHT * 4 / 32), fdec(0)));
        $this->initUint32($box + 0x34, $lineOffsets);
        $this->initUint32($box + 0x38, $text);

        $shouldLoadGlyphContext = [
            "box" => $box,
            "var_glyphTexnames_8c1bc78c" => $var_glyphTexnames_8c1bc78c,
            "var_glyphTexlists_8c1bc790" => $var_glyphTexlists_8c1bc790,
            "var_8c1bc7a0" => $var_8c1bc7a0,
            "glyphIndexes" => $glyphIndexes,
        ];

        $shouldDrawCharacterContext = [
            "box" => $box,
            "var_glyphTexlists_8c1bc790" => $var_glyphTexlists_8c1bc790,
        ];

        // Load and draw ‚
        $this->shouldLoadGlyph(
            ...$shouldLoadGlyphContext,
            charCode:              0x8281,
            glyphIndex:            0,
            newProcessedCharCount: 1
        );
        $this->shouldDrawCharacter(
            ...$shouldDrawCharacterContext,
            glyphIndex: 0,
            x:          0.0,
            y:          500.0,
            priority:   42.0
        );

        // Load and draw ‚‚
        $this->shouldLoadGlyph(
            ...$shouldLoadGlyphContext,
            charCode:              0x8282,
            glyphIndex:            1,
            newProcessedCharCount: 2
        );
        $this->shouldDrawCharacter(
            ...$shouldDrawCharacterContext,
            glyphIndex: 1,
            x:          24.0,
            y:          500.0,
            priority:   42.0
        );

        // Load and draw ‚
        $this->shouldLoadGlyph(
            ...$shouldLoadGlyphContext,
            charCode:              0x8281,
            glyphIndex:            2,
            newProcessedCharCount: 3
        );
        $this->shouldDrawCharacter(
            ...$shouldDrawCharacterContext,
            glyphIndex: 2,
            x:          48.0,
            y:          500.0,
            priority:   42.0
        );

        $this->call('_menuTextboxTextSub_8c0155e0')
            ->with($box, 3)
            ->shouldReturn(1)
            ->run();
    }

    protected function shouldLoadGlyph (
        int $charCode,
        int $glyphIndex,
        int $newProcessedCharCount,

        $box,
        $var_glyphTexnames_8c1bc78c,
        $var_glyphTexlists_8c1bc790,
        $var_8c1bc7a0,
        $glyphIndexes,
    ) {
        $texInfoLocal = $this->isAsmObject() ? 0xffffa8 : 0xffffac;

        $this->shouldCall('_unpackGlyph_8c015110')
            ->with(
                $charCode,
                $box + 0x24,
                0xcafe0001,
                0xcafe0002,
            );

        $this->shouldCall('_njSetTextureInfo')
            ->with($texInfoLocal, 0xcafe0002, 0x100, 32, 32);

        $this->shouldCall('_njSetTextureName')
            ->with(
                $var_glyphTexnames_8c1bc78c + $glyphIndex * 0xc,
                $texInfoLocal,
                $glyphIndex,
                0x40800000,
            );
        $this->shouldWriteLong(
            $var_glyphTexlists_8c1bc790 + $glyphIndex * 0x8 + 0x00,
            $var_glyphTexnames_8c1bc78c + $glyphIndex * 0xc,
        );
        $this->shouldWriteLong(
            $var_glyphTexlists_8c1bc790 + $glyphIndex * 0x8 + 0x04, 1
        );

        $this->shouldWriteWord(
            $var_8c1bc7a0 + $glyphIndex * 0x2, $glyphIndex
        );
        $this->shouldWriteWord(
            $glyphIndexes + $glyphIndex * 0x2, $glyphIndex
        );

        $this->shouldCall('_njLoadTexture')
            ->with($var_glyphTexlists_8c1bc790 + $glyphIndex * 0x8);

        $this->shouldWriteWord($box + 0x1c, $newProcessedCharCount);
    }

    protected function shouldDrawCharacter (
        int $glyphIndex,
        float $x,
        float $y,
        float $priority,

        $box,
        $var_glyphTexlists_8c1bc790,
    ) {
        $this->shouldWriteLong(
            $this->addressOf('_var_fontResourceGroup_8c1bc794') + 0x0,
            $var_glyphTexlists_8c1bc790 + $glyphIndex * 0x8,
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_var_fontResourceGroup_8c1bc794'),
            2000,
            $x,
            $y,
            $priority,
        );
    }

    protected function resolveSymbols(): void
    {
        $this->setSize('_var_glyphTexlists_8c1bc790', 4);
        $this->setSize('_var_glyphTexnames_8c1bc78c', 4);
        $this->setSize('_var_glyphBuffer_8c1bc7a4', 4);
        $this->setSize('_var_busFont_8c1ba1c8', 4);
        $this->setSize('_var_fontResourceGroup_8c1bc794', 0xc);
        // Functions
        $this->setSize('_njSetTextureInfo', 4);
        $this->setSize('_njSetTextureName', 4);
        $this->setSize('_njLoadTexture', 4);
        // $this->setSize('_strlen', 4);
    }

    protected function initUint16Array(int $address, array $values): void
    {
        foreach ($values as $i => $value) {
            $this->initUint16($address + $i * 2, $value);
        }
    }

    private function initUint32Array(int $address, array $values): void
    {
        foreach ($values as $i => $value) {
            $this->initUint32($address + $i * 4, $value);
        }
    }

    protected function isAsmObject(): bool
    {
        return str_ends_with($this->objectFile, '_src.obj');
    }
};
