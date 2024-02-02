<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

return new class extends TestCase {
    public function testCycleOptionAndPlaySound_8c016c58()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(0)
            ->run();
    }

    public function testCycleOptionAndPlaySound_8c016c58_right()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0x80);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->shouldRead($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->shouldWrite($optionPtr, 1);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(1)
            ->run();
    }

    public function testCycleOptionAndPlaySound_8c016c58_left()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 3);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0x40);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->shouldRead($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->shouldWrite($optionPtr, 2);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(1)
            ->run();
    }

    public function testCycleOptionAndPlaySound_8c016c58_rightWrapAround()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 2);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0x80);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->shouldRead($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->shouldWrite($optionPtr, 0);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(1)
            ->run();
    }

    public function testCycleOptionAndPlaySound_8c016c58_leftWrapAround()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0x40);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->shouldRead($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->shouldWrite($optionPtr, 2);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(1)
            ->run();
    }

    public function testCycleOptionAndPlaySound_8c016c58_noInput()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 1);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(0)
            ->run();
    }

    public function testFUN_8c016caa_Option0AndRight()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x80);

        $this->shouldWrite($optionPtr, 1);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->shouldRead($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(0)
            ->run();
    }

    public function testFUN_8c016caa_Option0AndRightAndA()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x84);

        $this->shouldWrite($optionPtr, 1);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 1, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(2)
            ->run();
    }

    public function testFUN_8c016caa_Option0AndRightAndB()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x82);

        $this->shouldWrite($optionPtr, 1);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 1, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(2)
            ->run();
    }

    public function testFUN_8c016caa_Option0AndLeft()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x40);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(0)
            ->run();
    }

    public function testFUN_8c016caa_Option0AndLeftAndA()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x44);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 0, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(1)
            ->run();
    }

    public function testFUN_8c016caa_Option0AndLeftAndB()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x42);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 1, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(2)
            ->run();
    }

    public function testFUN_8c016caa_Option1AndRight()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 1);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x80);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(0)
            ->run();
    }

    public function testFUN_8c016caa_Option1AndRightAndA()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 1);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x84);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 1, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(2)
            ->run();
    }

    public function testFUN_8c016caa_Option1AndRightAndB()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 1);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x82);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 1, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(2)
            ->run();
    }

    public function testFUN_8c016caa_Option1AndLeft()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 1);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x40);

        $this->shouldWrite($optionPtr, 0);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(0)
            ->run();
    }

    public function testFUN_8c016caa_Option1AndLeftAndA()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 1);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x44);

        $this->shouldWrite($optionPtr, 0);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 0, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(1)
            ->run();
    }

    public function testFUN_8c016caa_Option1AndLeftAndB()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 1);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x42);

        $this->shouldWrite($optionPtr, 0);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 1, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(2)
            ->run();
    }

    public function testFUN_8c016caa_Option0AndAndA()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x04);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 0, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(1)
            ->run();
    }

    public function testFUN_8c016caa_Option0AndAndB()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0x02);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->initUint32($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 1, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(2)
            ->run();
    }

    public function testFUN_8c016caa_Option0()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(0)
            ->run();
    }

    public function testFUN_8c016caa_Option1()
    {
        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);

        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->initUint32($peripheralPtr + 16, 0);

        $this->call('_FUN_8c016caa')
            ->with($optionPtr)
            ->shouldReturn(0)
            ->run();
    }
};
