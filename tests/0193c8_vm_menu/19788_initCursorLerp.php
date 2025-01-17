<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;
use Lhsazevedo\Sh4ObjTest\Simulator\Types\U32;

if (!function_exists('fdec')) {
    function fdec(float $value) {
        return unpack('L', pack('f', $value))[1];
    }
}

return new class extends TestCase {
    public function test_A()
    {
        $this->resolveSymbols();

        $drive = 1;
        $saveName = $this->allocString('TOKYOBUS.003');

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x20, fdec(290.0));
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x24, fdec(194.0));

        $this->shouldWriteLong($this->addressOf('_menuState_8c1bc7a8') + 0x28, fdec(255.0));
        $this->shouldWriteLong($this->addressOf('_menuState_8c1bc7a8') + 0x2c, fdec(98.0));
        $this->shouldWriteLong($this->addressOf('_menuState_8c1bc7a8') + 0x30, fdec((255.0 - 290.0) / 6));
        $this->shouldWriteLong($this->addressOf('_menuState_8c1bc7a8') + 0x34, fdec((98.0 - 194.0) / 6));

        $this->call('_initCursorLerp_19788')->with($drive)->run();
    }

    private function resolveSymbols(): void
    {
        $this->setSize('_menuState_8c1bc7a8', 0x6c);

        $this->setSize('_init_vmIconsPositions_8c044d7c', 0x24);
        $this->initUint32Array($this->addressOf('_init_vmIconsPositions_8c044d7c'), [
            fdec(185.0), fdec(98.0),
            fdec(255.0), fdec(98.0),
            fdec(325.0), fdec(98.0),
            fdec(395.0), fdec(98.0),
            fdec(150.0), fdec(194.0),
            fdec(220.0), fdec(194.0),
            fdec(290.0), fdec(194.0),
            fdec(360.0), fdec(194.0),
            fdec(430.0), fdec(194.0),
        ]);
    }

    private function initUint32Array(int $address, array $values): void
    {
        foreach ($values as $i => $value) {
            $this->initUint32($address + $i * 4, $value);
        }
    }
};
