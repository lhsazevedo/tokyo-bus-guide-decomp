<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

if (!function_exists('fdec')) {
    function fdec(float $value) {
        return unpack('L', pack('f', $value))[1];
    }
}

return new class extends TestCase {
    public function test_path_none()
    {
        // FIXME
        $this->doNotRandomizeMemory();

        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 0);

        $this->call('_FUN_8c0102d8')->run();
    }

    public function test_path_A()
    {
        // FIXME
        $this->doNotRandomizeMemory();

        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 0xf8);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x14, 128);
        $this->initUint32($this->addressOf('_var_8c1bbcb0'), 1);

        $this->shouldCall('_sdMidiSetPitch')
            ->with(0xcafe0006, -200, 0);
        $this->shouldCall('_sdMidiSetVol')
            ->with(0xcafe0006, 1, 0);
        $this->shouldCall('_sdMidiPlay')
            ->with(0xcafe0006, 1, 43, 0);

        $this->shouldWriteLongTo('_var_uknVol_8c0fcd50', 1);

        $this->call('_FUN_8c0102d8')->run();
    }

    public function test_path_C()
    {
        // FIXME
        $this->doNotRandomizeMemory();

        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 0xf9);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x14, 128);
        $this->initUint32($this->addressOf('_var_8c1bbcb0'), 0);

        $this->shouldCall('_sdMidiSetVol')->with(0xcafe0006, -127, 2000);

        $this->shouldWriteLongTo('_var_uknVol_8c0fcd50', 0xf8);

        $this->call('_FUN_8c0102d8')->run();
    }

    public function test_path_D()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 0xf8);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x14, 128);
        $this->initUint32($this->addressOf('_var_8c1bbcb0'), 0);
        $this->initUint32($this->addressOf('_var_uknVol_8c226468'), fdec(400.1));

        $this->shouldCall('_sdMidiSetPitch')
            ->with(0xcafe0007, 0, 0);
        $this->shouldCall('_sdMidiSetVol')
            ->with(0xcafe0007, -127, 0);
        $this->shouldCall('_sdMidiPlay')
            ->with(0xcafe0007, 1, 44, 0);

        $this->shouldWriteLongTo('_var_uknVol_8c0fcd50', 0xfa);

        $this->call('_FUN_8c0102d8')->run();
    }

    public function test_path_F()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 0b10);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x14, 128);
        $this->initUint32($this->addressOf('_var_8c1bbcb0'), 0);
        $this->initUint32($this->addressOf('_var_uknVol_8c226468'), fdec(399.9));

        $this->shouldWriteLongTo('_var_uknVol_8c0fcd50', 0);

        $this->call('_FUN_8c0102d8')->run();
    }

    public function test_path_G()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 0b010);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x14, 128);
        $this->initUint32($this->addressOf('_var_8c1bbcb0'), 0);
        $this->initUint32($this->addressOf('_var_uknVol_8c226468'), fdec(2100.1));

        $this->shouldCall('_sdMidiSetPitch')
            ->with(0xcafe0006, 0, 0);
        $this->shouldCall('_sdMidiSetVol')
            ->with(0xcafe0006, -127, 0);
        $this->shouldCall('_sdMidiPlay')
            ->with(0xcafe0006, 1, 45, 0);

        $this->shouldWriteLongTo('_var_uknVol_8c0fcd50', 0b110);

        $this->call('_FUN_8c0102d8')->run();
    }

    private function resolveSymbols(): void
    {
        $this->setSize('_var_uknVol_8c226468', 4);
        $this->setSize('_var_8c1bbcb0', 4);

        // Functions
        $this->setSize('_sdMidiSetPitch', 4);
        $this->setSize('_sdMidiPlay', 4);
        $this->setSize('_sdMidiSetVol', 4);

        // Basic inits
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 0 * 4, 0xcafe0000);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 1 * 4, 0xcafe0001);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 2 * 4, 0xcafe0002);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 3 * 4, 0xcafe0003);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 4 * 4, 0xcafe0004);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 5 * 4, 0xcafe0005);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 6 * 4, 0xcafe0006);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 7 * 4, 0xcafe0007);
    }
};
