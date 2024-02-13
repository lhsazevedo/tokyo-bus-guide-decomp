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

        $this->shouldWrite($optionPtr, 0);

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

        $this->shouldWrite($optionPtr, 1);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(0)
            ->run();
    }
};
