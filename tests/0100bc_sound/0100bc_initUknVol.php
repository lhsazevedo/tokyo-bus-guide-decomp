<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

function fdec(float $value) {
    return unpack('L', pack('f', $value))[1];
}

return new class extends TestCase {
    public function test_basic()
    {
        $this->setSize('__divls', 0x4);

        $this->shouldWriteLong($this->addressOf('_var_uknVol_8c0fcd50') + 0x18, fdec(0.048846155));
        $this->shouldWriteLong($this->addressOf('_var_uknVol_8c0fcd50') + 0x1C, fdec(0.042333334));
        $this->shouldWriteLong($this->addressOf('_var_uknVol_8c0fcd50') + 0x14, 38);
        $this->shouldWriteLong($this->addressOf('_var_uknVol_8c0fcd50') + 0x08, 50);
        $this->shouldWriteLong($this->addressOf('_var_uknVol_8c0fcd50') + 0x0c, 146);
        $this->shouldWriteLong($this->addressOf('_var_uknVol_8c0fcd50') + 0x20, fdec(0.032564103));

        $this->call('_initUknVol_8c0100bc')->run();
    }
};
