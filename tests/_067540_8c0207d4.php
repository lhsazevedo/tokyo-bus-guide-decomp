<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

function fdec(float $value) {
    return unpack('L', pack('f', $value))[1];
}

return new class extends TestCase {
    public function testFUN_8c0207d4() {
        $aPtr = $this->alloc(0x0c);
        $bPtr = $this->alloc(0x0c);
        $cPtr = $this->alloc(0x0c);

        $this->initUint32($aPtr + 0x00, fdec(2.0));
        $this->initUint32($aPtr + 0x04, fdec(3.0));
        $this->initUint32($aPtr + 0x08, fdec(4.0));

        $this->initUint32($bPtr + 0x00, fdec(5.0));
        $this->initUint32($bPtr + 0x00, fdec(6.0));
        $this->initUint32($bPtr + 0x00, fdec(7.0));

        $this->initUint32($cPtr + 0x00, fdec(8.0));
        $this->initUint32($cPtr + 0x00, fdec(9.0));
        $this->initUint32($cPtr + 0x00, fdec(10.0));

        $this->call('_FUN_8c0207d4')
            ->with($aPtr, $bPtr, $cPtr)
            ->shouldReturn(56.0)
            ->run();
    }

    public function testFUN_8c0207d4_2() {
        $aPtr = $this->alloc(0x0c);
        $bPtr = $this->alloc(0x0c);
        $cPtr = $this->alloc(0x0c);

        $this->initUint32($aPtr + 0x00, fdec(10.0));
        $this->initUint32($aPtr + 0x04, fdec(9.0));
        $this->initUint32($aPtr + 0x08, fdec(8.0));

        $this->initUint32($bPtr + 0x00, fdec(7.0));
        $this->initUint32($bPtr + 0x00, fdec(6.0));
        $this->initUint32($bPtr + 0x00, fdec(5.0));

        $this->initUint32($cPtr + 0x00, fdec(4.0));
        $this->initUint32($cPtr + 0x00, fdec(3.0));
        $this->initUint32($cPtr + 0x00, fdec(2.0));

        $this->call('_FUN_8c0207d4')
            ->with($aPtr, $bPtr, $cPtr)
            ->shouldReturn(104.0)
            ->run();
    }

    public function testFUN_8c0207fa() {
        $aPtr = $this->alloc(0x0c);
        $bPtr = $this->alloc(0x0c);
        $cPtr = $this->alloc(0x0c);

        $this->initUint32($aPtr + 0x00, fdec(2.0));
        $this->initUint32($aPtr + 0x04, fdec(3.0));
        $this->initUint32($aPtr + 0x08, fdec(4.0));

        $this->initUint32($bPtr + 0x00, fdec(5.0));
        $this->initUint32($bPtr + 0x00, fdec(6.0));
        $this->initUint32($bPtr + 0x00, fdec(7.0));

        $this->initUint32($cPtr + 0x00, fdec(8.0));
        $this->initUint32($cPtr + 0x00, fdec(9.0));
        $this->initUint32($cPtr + 0x00, fdec(10.0));

        $this->call('_FUN_8c0207fa')
            ->with($aPtr, $bPtr, $cPtr)
            ->shouldReturn(12.0)
            ->run();
    }

    public function testFUN_8c0207fa_2() {
        $aPtr = $this->alloc(0x0c);
        $bPtr = $this->alloc(0x0c);
        $cPtr = $this->alloc(0x0c);

        $this->initUint32($aPtr + 0x00, fdec(10.0));
        $this->initUint32($aPtr + 0x04, fdec(9.0));
        $this->initUint32($aPtr + 0x08, fdec(8.0));

        $this->initUint32($bPtr + 0x00, fdec(7.0));
        $this->initUint32($bPtr + 0x00, fdec(6.0));
        $this->initUint32($bPtr + 0x00, fdec(5.0));

        $this->initUint32($cPtr + 0x00, fdec(4.0));
        $this->initUint32($cPtr + 0x00, fdec(3.0));
        $this->initUint32($cPtr + 0x00, fdec(2.0));

        $this->call('_FUN_8c0207fa')
            ->with($aPtr, $bPtr, $cPtr)
            ->shouldReturn(-24.0)
            ->run();
    }
};
