<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;
use Lhsazevedo\Sh4ObjTest\Simulator\Types\U32;

return new class extends TestCase {
    public function test_init_it_waits_for_pvm_bool()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x18, 0);
        $task = 0xbebacafe;

        $this->shouldCall('_getUknPvmBool_8c01432a')->andReturn(1);

        $this->call('_MainMenuTask_8c019e98')->with($task)->run();
    }

    public function test_init_it_advances()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x18, 0);

        $this->shouldCall('_getUknPvmBool_8c01432a')->andReturn(0);
        $this->shouldCall('_AsqFreeQueues_11f7e');
        $this->shouldWriteLong($this->addressOf('_menuState_8c1bc7a8') + 0x18, 1);
        $this->shouldCall('_push_fadein_8c022a9c')->with(10);

        $this->call('_MainMenuTask_8c019e98')->with(0xbebacafe)->run();
    }

    public function test_fade_in_waits_for_fade()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x18, 1);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x5c, 0);
        $this->initUint32($this->addressOf('_isFading_8c226568'), 1);

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x65 + 0,
            0.0,
            0.0,
            -4.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x64,
            0.0,
            0.0,
            -5.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x00,
            0x2d,
            0.0,
            0.0,
            -7.0
        );

        $this->call('_MainMenuTask_8c019e98')->with(0xbebacafe)->run();
    }

    public function test_fade_in_advances()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x18, 1);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x5c, 0);
        $this->initUint32($this->addressOf('_isFading_8c226568'), 0);

        $this->shouldWriteLong($this->addressOf('_menuState_8c1bc7a8') + 0x18, 2);

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x65 + 0,
            0.0,
            0.0,
            -4.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x64,
            0.0,
            0.0,
            -5.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x00,
            0x2d,
            0.0,
            0.0,
            -7.0
        );

        $this->call('_MainMenuTask_8c019e98')->with(0xbebacafe)->run();
    }

    public function test_idle_state_when_no_input()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x18, 2);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x5c, 0);
        $this->initUint32($this->addressOf('_var_peripheral_8c1ba35c') + 0x10, 0);
        $this->initUint32(
            $this->addressOf('_var_midiHandles_8c0fcd28'), 0xbeef0000
        );

        // $this->shouldCall('_sdMidiPlay')->with(0xbeef0000, 1, 3, 0);

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x65 + 0,
            0.0,
            0.0,
            -4.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x64,
            0.0,
            0.0,
            -5.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x00,
            0x2d,
            0.0,
            0.0,
            -7.0
        );

        $this->call('_MainMenuTask_8c019e98')->with(0xbebacafe)->run();
    }

    public function test_idle_state_when_input_left_and_on_first_option()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x18, 2);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x5c, 0);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x38, 0);
        $this->initUint32($this->addressOf('_var_peripheral_8c1ba35c') + 0x10, 0x40);
        $this->initUint32(
            $this->addressOf('_var_midiHandles_8c0fcd28'), 0xbeef0000
        );

        // $this->shouldCall('_sdMidiPlay')->with(0xbeef0000, 1, 3, 0);

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x65 + 0,
            0.0,
            0.0,
            -4.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x64,
            0.0,
            0.0,
            -5.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x00,
            0x2d,
            0.0,
            0.0,
            -7.0
        );

        $this->call('_MainMenuTask_8c019e98')->with(0xbebacafe)->run();
    }

    public function test_idle_state_when_input_right_and_on_last_option()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x18, 2);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x5c, 0);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x38, 3);
        $this->initUint32($this->addressOf('_var_peripheral_8c1ba35c') + 0x10, 0x80);
        $this->initUint32(
            $this->addressOf('_var_midiHandles_8c0fcd28'), 0xbeef0000
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x65 + 0,
            0.0,
            0.0,
            -4.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x64,
            0.0,
            0.0,
            -5.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x00,
            0x2d,
            0.0,
            0.0,
            -7.0
        );

        $this->call('_MainMenuTask_8c019e98')->with(0xbebacafe)->run();
    }

    public function test_idle_state_when_input_left_on_third_option()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x18, 2);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x5c, 0);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x38, 2);
        $this->initUint32($this->addressOf('_var_peripheral_8c1ba35c') + 0x10, 0x40);
        $this->initUint32(
            $this->addressOf('_var_midiHandles_8c0fcd28'), 0xbeef0000
        );

        $this->shouldCall('_sdMidiPlay')->with(0xbeef0000, 1, 3, 0);
        $this->shouldWrite($this->addressOf('_menuState_8c1bc7a8') + 0x38, 1);
        $this->shouldWrite($this->addressOf('_menuState_8c1bc7a8') + 0x18, 4);
        $this->shouldWrite($this->addressOf('_menuState_8c1bc7a8') + 0x64, 0);
        $this->shouldWrite($this->addressOf('_menuState_8c1bc7a8') + 0x68, 0);

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x65 + 0,
            0.0,
            0.0,
            -4.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x64,
            0.0,
            0.0,
            -5.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x00,
            0x2d,
            0.0,
            0.0,
            -7.0
        );

        $this->call('_MainMenuTask_8c019e98')->with(0xbebacafe)->run();
    }

    public function test_idle_state_when_input_right_on_third_option()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x18, 2);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x5c, 0);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x38, 2);
        $this->initUint32($this->addressOf('_var_peripheral_8c1ba35c') + 0x10, 0x80);
        $this->initUint32(
            $this->addressOf('_var_midiHandles_8c0fcd28'), 0xbeef0000
        );

        $this->shouldCall('_sdMidiPlay')->with(0xbeef0000, 1, 3, 0);
        $this->shouldWrite($this->addressOf('_menuState_8c1bc7a8') + 0x38, 3);
        $this->shouldWrite($this->addressOf('_menuState_8c1bc7a8') + 0x18, 3);
        $this->shouldWrite($this->addressOf('_menuState_8c1bc7a8') + 0x64, 0);
        $this->shouldWrite($this->addressOf('_menuState_8c1bc7a8') + 0x68, 0);

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x65 + 0,
            0.0,
            0.0,
            -4.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x64,
            0.0,
            0.0,
            -5.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x00,
            0x2d,
            0.0,
            0.0,
            -7.0
        );

        $this->call('_MainMenuTask_8c019e98')->with(0xbebacafe)->run();
    }

    public function test_idle_state_when_input_a_on_free_run_option()
    {
        $this->resolveSymbols();

        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x18, 2);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x5c, 0);
        $this->initUint32($this->addressOf('_menuState_8c1bc7a8') + 0x38, 1);
        $this->initUint32(
            $this->addressOf('_var_peripheral_8c1ba35c') + 0x10, 0x04
        );
        $this->initUint32(
            $this->addressOf('_var_midiHandles_8c0fcd28'), 0xbeef0000
        );

        $this->shouldCall('_sdMidiPlay')->with(0xbeef0000, 1, 0, 0);
        $this->shouldWrite($this->addressOf('_menuState_8c1bc7a8') + 0x18, 5);
        $this->shouldCall('_push_fadeout_8c022b60')->with(10);

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x65 + 0,
            0.0,
            0.0,
            -4.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x0c,
            0x64,
            0.0,
            0.0,
            -5.0
        );

        $this->shouldCall('_drawSprite_8c014f54')->with(
            $this->addressOf('_menuState_8c1bc7a8') + 0x00,
            0x2d,
            0.0,
            0.0,
            -7.0
        );

        $this->call('_MainMenuTask_8c019e98')->with(0xbebacafe)->run();
    }

    private function resolveSymbols(): void
    {
        $this->setSize('_menuState_8c1bc7a8', 0x6c);
        $this->setSize('_isFading_8c226568', 4);
        $this->setSize('_var_peripheral_8c1ba35c', 52 * 2);
        $this->initUint32($this->addressOf('_var_midiHandles_8c0fcd28'), 0xbeef0000);

        // Functions
        $this->setSize('_drawSprite_8c014f54', 0x4);
        $this->setSize('_sdMidiPlay', 0x4);
    }
};
