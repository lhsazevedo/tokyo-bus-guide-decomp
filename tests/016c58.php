<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

return new class extends TestCase {
    public function testCycleOptionAndPlaySound_8c016c58()
    {
        $this->resolveImports();

        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);
        $this->initUint32($this->addressOf('_peripheral_8c1ba35c') + 16, 0);

        $this->shouldWrite($optionPtr, 0);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(0)
            ->run();
    }

    public function testCycleOptionAndPlaySound_8c016c58_right()
    {
        $this->resolveImports();

        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);
        $this->initUint32($this->addressOf('_peripheral_8c1ba35c') + 16, 0x80);
        $this->initUint32($this->addressOf('_midiHandles_8c0fcd28'), 0xbebacafe);

        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->shouldWrite($optionPtr, 1);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(1)
            ->run();
    }

    public function testCycleOptionAndPlaySound_8c016c58_left()
    {
        $this->resolveImports();

        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 3);
        $this->initUint32($this->addressOf('_peripheral_8c1ba35c') + 16, 0x40);
        $this->initUint32($this->addressOf('_midiHandles_8c0fcd28'), 0xbebacafe);
        
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->shouldWrite($optionPtr, 2);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(1)
            ->run();
    }

    public function testCycleOptionAndPlaySound_8c016c58_rightWrapAround()
    {
        $this->resolveImports();

        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 2);
        $this->initUint32($this->addressOf('_peripheral_8c1ba35c') + 16, 0x80);
        $this->initUint32($this->addressOf('_midiHandles_8c0fcd28'), 0xbebacafe);

        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->shouldWrite($optionPtr, 0);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(1)
            ->run();
    }

    public function testCycleOptionAndPlaySound_8c016c58_leftWrapAround()
    {
        $this->resolveImports();

        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 0);
        $this->initUint32($this->addressOf('_peripheral_8c1ba35c') + 16, 0x40);
        $this->initUint32($this->addressOf('_midiHandles_8c0fcd28'), 0xbebacafe);

        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 3, 0);

        $this->shouldWrite($optionPtr, 2);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(1)
            ->run();
    }

    public function testCycleOptionAndPlaySound_8c016c58_noInput()
    {
        $this->resolveImports();

        $optionPtr = $this->alloc(0x0c);
        $this->initUint32($optionPtr, 1);
        $this->initUint32($this->addressOf('_peripheral_8c1ba35c') + 16, 0);

        $this->shouldWrite($optionPtr, 1);

        $this->call('_cycleOptionAndPlaySound_8c016c58')
            ->with($optionPtr, 3)
            ->shouldReturn(0)
            ->run();
    }

    private function resolveImports() {
        // sizeof PERIPHERAL = 52
        $this->setSize('_peripheral_8c1ba35c', 52 * 2);
        $this->setSize('_midiHandles_8c0fcd28', 0x8);
    }
};
