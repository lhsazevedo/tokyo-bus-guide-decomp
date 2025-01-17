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
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 0);

        $this->call('_midiSetVol_8c010128')->run();
    }

    public function test_path_A()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 2);
        $this->initUint32($this->addressOf('_var_uknVol_8c226468'), fdec(9.9));

        $this->call('_midiSetVol_8c010128')->run();
    }

    public function test_path_A2()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), fdec(3000.0));
        $this->initUint32($this->addressOf('_var_uknVol_8c226468'), fdec(9.9));

        $this->call('_midiSetVol_8c010128')->run();
    }

    public function test_path_B()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c226468'), fdec(2000.5));
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 2);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x08, 50);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x18, fdec(0.048846155));

        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 7 * 4, 0xcafe0007);

        $this->shouldCall('_sdMidiSetVol')
            ->with(
                0xcafe0007,
                (int) (50 + 1990.0 * 0.048846155 - 127),
                0
            );

        $this->call('_midiSetVol_8c010128')->run();
    }

    public function test_path_C()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c226468'), fdec(3010.0));
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 2);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x0c, 50);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x1c, fdec(0.042333334));

        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 7 * 4, 0xcafe0007);

        $this->shouldCall('_sdMidiSetVol')
            ->with(
                0xcafe0007,
                (int) (50 - 10.0 * 0.042333334 - 127),
                0
            );

        $this->call('_midiSetVol_8c010128')->run();
    }

    public function test_path_D()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 4);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 6 * 4, 0xcafe0006);
        $this->initUint32($this->addressOf('_var_uknVol_8c226468'), fdec(2100.0));
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x20, fdec(0.032564103));

        $this->shouldCall('_sdMidiSetVol')
            ->with(
                0xcafe0006,
                (int) (1100.0 * 0.032564103 - 127),
                0
            );

        $this->call('_midiSetVol_8c010128')->run();
    }

    public function test_path_E()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 4);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 6 * 4, 0xcafe0006);
        $this->initUint32($this->addressOf('_var_uknVol_8c226468'), fdec(2000.0));
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x20, fdec(0.032564103));

        $this->shouldCall('_sdMidiSetVol')
            ->with(
                0xcafe0006,
                (int) (1000.0 * 0.032564103 - 127),
                0
            );

        $this->shouldWriteLongTo('_var_uknVol_8c0fcd50', 0);

        $this->shouldCall('_sdMidiSetVol')
            ->with(
                0xcafe0006,
                -127,
                0
            );

        $this->call('_midiSetVol_8c010128')->run();
    }

    public function test_path_BE()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50'), 6);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x08, 50);
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x18, fdec(0.048846155));
        $this->initUint32($this->addressOf('_var_uknVol_8c0fcd50') + 0x20, fdec(0.032564103));

        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 6 * 4, 0xcafe0006);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28') + 7 * 4, 0xcafe0007);
        
        $this->initUint32($this->addressOf('_var_uknVol_8c226468'), fdec(2000.0));

        $this->shouldCall('_sdMidiSetVol')
            ->with(
                0xcafe0007,
                (int) (50 + 1990.0 * 0.048846155 - 127),
                0
            );


        $this->shouldCall('_sdMidiSetVol')
            ->with(
                0xcafe0006,
                (int) (1000.0 * 0.032564103 - 127),
                0
            );

        $this->shouldWriteLongTo('_var_uknVol_8c0fcd50', 2);

        $this->shouldCall('_sdMidiSetVol')
            ->with(
                0xcafe0006,
                -127,
                0
            );

        $this->call('_midiSetVol_8c010128')->run();
    }

    protected function resolveSymbols()
    {
        $this->setSize('_var_uknVol_8c226468', 4);

        // Functions
        $this->setSize('_sdMidiSetVol', 4);
    }
};
