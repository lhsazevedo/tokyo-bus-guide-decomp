<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

return new class extends TestCase {
    public function testState0x00_Init_SkipTitleAnimationWhenStartIsPressed() {
        $this->shouldReadSymbolOffset('_menuState_8c1bc7a8', 0x18, 0x0b);
        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $this->shouldReadSymbolOffset('_peripheral_8c1ba35c', 16, 8);

        $this->shouldReadSymbolOffset('_midiHandles_8c0fcd28', 0, 0xbebacafe);

        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 0, 0);

        $this->shouldWriteSymbolOffset('_peripheral_8c1ba35c', 16, 0);
        $this->shouldWriteSymbolOffset('_menuState_8c1bc7a8', 0x18, 0x0e);
        $this->shouldWriteSymbolOffset('_isFading_8c226568', 0, 0);

        $this->forceStop();

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x00_Init_AdvanceToFortyFiveFadeIn() {
        $this->shouldReadSymbolOffset('_menuState_8c1bc7a8', 0x18, 0);
        $this->shouldReadSymbolOffset('_menuState_8c1bc7a8', 0x18, 0);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        //$this->shouldReadSymbolOffset('peripheral_8c1ba35c', 16, 0);

        $this->shouldCall('_getUknPvmBool_8c01432a')->andReturn(0);
        $this->shouldCall('_FUN_8c011f7e');
        $this->shouldCall('_FUN_8c01940e');

        // TODO: Fix Task size
        $taskPtr = $this->alloc(0x0c);
        $this->shouldRead($taskPtr + 0x08, 0);

        $this->shouldWriteSymbolOffset('_menuState_8c1bc7a8', 0x18, 1);

        $this->shouldCall('_push_fadein_8c022a9c')->with(20);

        $this->shouldCall('_njSetBackColor')->with(0xff000000, 0xff000000, 0xff000000);

        $this->call('_task_title_8c015ab8')
            ->with($taskPtr, 0)
            ->run();
    }

    public function testState0x00_Init_NoopWhenUknPvmBoolIsTrue() {
        $this->shouldReadSymbolOffset('_menuState_8c1bc7a8', 0x18, 0);
        $this->shouldReadSymbolOffset('_menuState_8c1bc7a8', 0x18, 0);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        //$this->shouldReadSymbolOffset('peripheral_8c1ba35c', 16, 0);

        $this->shouldCall('_getUknPvmBool_8c01432a')->andReturn(1);

        // TODO: Fix Task size
        $taskPtr = $this->alloc(0x0c);

        $this->call('_task_title_8c015ab8')
            ->with($taskPtr, 0)
            ->run();
    }

    public function testState0x00_Init_SkipToTitleFadeInDirectWhenTaskField0x08IsTrue() {
        $this->shouldReadSymbolOffset('_menuState_8c1bc7a8', 0x18, 0);
        $this->shouldReadSymbolOffset('_menuState_8c1bc7a8', 0x18, 0);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        //$this->shouldReadSymbolOffset('peripheral_8c1ba35c', 16, 0);

        $this->shouldCall('_getUknPvmBool_8c01432a')->andReturn(0);
        $this->shouldCall('_FUN_8c011f7e');
        $this->shouldCall('_FUN_8c01940e');

        // TODO: Fix Task size
        $taskPtr = $this->alloc(0x0c);
        $this->shouldRead($taskPtr + 0x08, 1);

        $this->shouldWriteSymbolOffset('_menuState_8c1bc7a8', 0x18, 0x0d);

        $this->shouldCall('_push_fadein_8c022a9c')->with(10);

        $this->shouldCall('_njSetBackColor')->with(0xffffffff, 0xffffffff, 0xffffffff);

        $this->call('_task_title_8c015ab8')
            ->with($taskPtr, 0)
            ->run();
    }

    public function testState0x01_FortyfiveFadeIn_WaitsForFadeInBeforeAdvancing() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 1);
        $this->shouldRead($menuStatePtr + 0x18, 1);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 0, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x01_FortyfiveFadeIn_AdvancesWhenFadeInIsOver() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 1);
        $this->shouldRead($menuStatePtr + 0x18, 1);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 2);
        // Init logo timer
        $this->shouldWrite($menuStatePtr + 0x68, 0);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 0, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x02_Fortyfive_WaitsForTimerBeforePushingFadeOut() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 2);
        $this->shouldRead($menuStatePtr + 0x18, 2);

        // Check timer
        $this->shouldRead($menuStatePtr + 0x68, 29);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 0, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x02_Fortyfive_PushesFadeOutAfterThirteenTicks() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 2);
        $this->shouldRead($menuStatePtr + 0x18, 2);

        // Check timer
        $this->shouldRead($menuStatePtr + 0x68, 30);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 3);

        $this->shouldCall('_push_fadeout_8c022b60')->with(20);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 0, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x03_FortyfiveFadeOut_WaitsForFadeOutBeforeAdvancing() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 3);
        $this->shouldRead($menuStatePtr + 0x18, 3);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 0, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x03_FortyfiveFadeOut_AdvancesAndPushesFadeInAfterFadeOut() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 3);
        $this->shouldRead($menuStatePtr + 0x18, 3);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 4);
        $this->shouldCall('_push_fadein_8c022a9c')->with(20);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x04_AdxFadeIn_WaitsForFadeInBeforeAdvancing() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 4);
        $this->shouldRead($menuStatePtr + 0x18, 4);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 3, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x04_AdxFadeIn_AdvancesWhenFadeInIsOver() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 4);
        $this->shouldRead($menuStatePtr + 0x18, 4);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 5);
        // Init logo timer
        $this->shouldWrite($menuStatePtr + 0x68, 0);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 3, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x05_Adx_WaitsForTimerBeforePushingFadeOut() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 5);
        $this->shouldRead($menuStatePtr + 0x18, 5);

        // Check timer
        $this->shouldRead($menuStatePtr + 0x68, 29);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 3, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x05_Adx_PushesFadeOutAfterThirteenTicks() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 5);
        $this->shouldRead($menuStatePtr + 0x18, 5);

        // Check timer
        $this->shouldRead($menuStatePtr + 0x68, 30);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 6);

        $this->shouldCall('_push_fadeout_8c022b60')->with(20);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 3, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x06_AdxFadeOut_WaitsForFadeOutBeforeAdvancing() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 6);
        $this->shouldRead($menuStatePtr + 0x18, 6);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 3, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x06_AdxFadeOut_AdvancesToTitleWhenFirstConditionFails() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 6);
        $this->shouldRead($menuStatePtr + 0x18, 6);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        $this->shouldCall('_FUN_8c012984')->andReturn(0);

        // $saveNamesPtr = $this->alloc(0x4);
        // $this->rellocate('_saveNames_8c044d50', $saveNamesPtr);
        // $this->shouldCall('_FUN_8c019550')->with($saveNamesPtr, 3)->andReturn(1);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x0a);
        $this->shouldCall('_push_fadein_8c022a9c')->with(10);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x06_AdxFadeOut_AdvancesToTitleWhenSecondConditionFails() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 6);
        $this->shouldRead($menuStatePtr + 0x18, 6);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        $this->shouldCall('_FUN_8c012984')->andReturn(1);

        $saveNamesPtr = $this->alloc(0x4);
        $this->rellocate('_saveNames_8c044d50', $saveNamesPtr);
        $this->shouldCall('_FUN_8c019550')->with($saveNamesPtr, 3)->andReturn(1);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x0a);
        $this->shouldCall('_push_fadein_8c022a9c')->with(10);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x06_AdxFadeOut_AdvancesToWarningWhenBothConditionsPasses() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 6);
        $this->shouldRead($menuStatePtr + 0x18, 6);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        $this->shouldCall('_FUN_8c012984')->andReturn(1);

        $saveNamesPtr = $this->alloc(0x4);
        $this->rellocate('_saveNames_8c044d50', $saveNamesPtr);
        $this->shouldCall('_FUN_8c019550')->with($saveNamesPtr, 3)->andReturn(0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x07);
        $this->shouldCall('_push_fadein_8c022a9c')->with(10);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x047_VmuWarningFadeIn_WaitsForFadeInBeforeAdvancing() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 7);
        $this->shouldRead($menuStatePtr + 0x18, 7);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 17, 0.0, 0.0, -5.0);
        $this->shouldCall('_njSetBackColor')->with(0xffffffff, 0xffffffff, 0xffffffff);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x07_VmuWarningFadeIn_AdvancesWhenFadeInIsOver() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 7);
        $this->shouldRead($menuStatePtr + 0x18, 7);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 8);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 17, 0.0, 0.0, -5.0);
        $this->shouldCall('_njSetBackColor')->with(0xffffffff, 0xffffffff, 0xffffffff);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x08_VmuWarning_WaitsWhenNoInputOrSaveNames() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 8);
        $this->shouldRead($menuStatePtr + 0x18, 8);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0);

        $saveNamesPtr = $this->alloc(0x4);
        $this->rellocate('_saveNames_8c044d50', $saveNamesPtr);
        $this->shouldCall('_FUN_8c019550')->with($saveNamesPtr, 3)->andReturn(0);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 17, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x08_VmuWarning_AdvancesWhenStartIsPressed() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 8);
        $this->shouldRead($menuStatePtr + 0x18, 8);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 1 << 3);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->shouldRead($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 9);

        $this->shouldCall('_push_fadeout_8c022b60')->with(10);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 17, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x08_VmuWarning_AdvancesWhenAIsPressed() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 8);
        $this->shouldRead($menuStatePtr + 0x18, 8);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 1 << 2);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->shouldRead($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 9);

        $this->shouldCall('_push_fadeout_8c022b60')->with(10);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 17, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x08_VmuWarning_DoesNotAdvancesWhenOtherButtonsArePressed() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 8);
        $this->shouldRead($menuStatePtr + 0x18, 8);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0xFFFFFFF3);

        $saveNamesPtr = $this->alloc(0x4);
        $this->rellocate('_saveNames_8c044d50', $saveNamesPtr);
        $this->shouldCall('_FUN_8c019550')->with($saveNamesPtr, 3)->andReturn(0);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 17, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x08_VmuWarning_AdvancesWhenSaveNamePasses() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 8);
        $this->shouldRead($menuStatePtr + 0x18, 8);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0);

        $saveNamesPtr = $this->alloc(0x4);
        $this->rellocate('_saveNames_8c044d50', $saveNamesPtr);
        $this->shouldCall('_FUN_8c019550')->with($saveNamesPtr, 3)->andReturn(1);

        $midiHandlesPtr = $this->alloc(4);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->shouldRead($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 9);

        $this->shouldCall('_push_fadeout_8c022b60')->with(10);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 17, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x09_VmuWarningFadeOut_WaitsForFadeOutBeforeAdvancing() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 9);
        $this->shouldRead($menuStatePtr + 0x18, 9);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 17, 0.0, 0.0, -5.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x09_VmuWarningFadeOut_AdvancesToTitleAfterFadeOut() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 0x09);
        $this->shouldRead($menuStatePtr + 0x18, 0x09);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x0a);
        $this->shouldCall('_push_fadein_8c022a9c')->with(10);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0a_TitleFadeIn_WaitsForFadeInBeforeAdvancing() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 0x0a);
        $this->shouldRead($menuStatePtr + 0x18, 0x0a);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        // // Advance title state
        // $this->shouldWrite($menuStatePtr + 0x18, 0x0a);
        // $this->shouldWrite($menuStatePtr + 0x20, 640);

        // $this->shouldCall('_snd_8c010cd6')->with(0,0);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0a_TitleFadeIn_AdvancesAfterFadeIn() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);

        $this->shouldRead($menuStatePtr + 0x18, 0x0a);
        $this->shouldRead($menuStatePtr + 0x18, 0x0a);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x0b);
        // 640.0 is stored as 0x44200000
        $this->shouldWrite($menuStatePtr + 0x20, 0x44200000);

        $this->shouldCall('_snd_8c010cd6')->with(0,0);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0b_BusSlide_AnimatesBusSlide() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0b);

        // Anim skip check
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0b);

        // 640.0 is stored as 0x44200000
        $this->shouldRead($menuStatePtr + 0x20, 0x44200000);
        // 634.888889
        $this->shouldWrite($menuStatePtr + 0x20, 0x441eb8e4);

        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 634.888889, 0.0, -4.0);
        
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0b_BusSlide_AdvancesWhenBusReachesCenterOfScreen() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0b);

        // Anim skip check
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0b);

        // 185.0 is stored as 0x43390000
        $this->shouldRead($menuStatePtr + 0x20, 0x43390000);
        // 185.0 - 5.111111 is stored as 0x4333e38e
        // $this->shouldWrite($menuStatePtr + 0x20, 0x4333e38e);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x0c);
        // Init flag Y position as 167.0
        $this->shouldWrite($menuStatePtr + 0x24, 0x43270000);

        // A break statement is missing, so we continue
        // to the next switch case (Flag Reveal).

        // 164.666671753
        $this->shouldWrite($menuStatePtr + 0x24, 0x4324aaab);

        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 164.666671753, -4.5);

        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);

        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0c_FlagReveal_AnimatesFlag() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0c);

        // Anim skip check
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0c);

        // 167.0 is stored as 0x43270000
        $this->shouldRead($menuStatePtr + 0x24, 0x43270000);
        // 164.666671753
        $this->shouldWrite($menuStatePtr + 0x24, 0x4324aaab);

        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 164.666671753, -4.5);

        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0c_FlagReveal_AdvancesWhenFlagIsRevealed() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0c);

        // Anim skip check
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0c);

        // 98 is stored as 0x42c40000
        $this->shouldRead($menuStatePtr + 0x24, 0x42c40000);
        // 95.6666641235
        $this->shouldWrite($menuStatePtr + 0x24, 0x42bf5555);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x0e);

        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 95.6666641235, -4.5);

        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0d_TitleFadeInDirect_WaitsForFadeIn() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0d);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0d);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        // TODO: assert that state is still 0x0d when drawSprite is called;

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 6, 0.0, 0.0, -4.5);
        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0d_TitleFadeInDirect_AdvancesAfterFadeIn() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0d);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0d);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x0e);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 6, 0.0, 0.0, -4.5);
        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0e_PressStart_WaitsWhenNoInputAndTimeIsNotUp() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0e);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0e);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0);

        $this->shouldRead($menuStatePtr + 0x64, 1049);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 6, 0.0, 0.0, -4.5);
        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0e_PressStart_AdvancesToStartPressedWhenStartIsPressed() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0e);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0e);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 1 << 3);

        $this->shouldCall('_FUN_8c010bae')->with(0);
        $this->shouldCall('_FUN_8c010bae')->with(1);

        $midiHandlesPtr = $this->alloc(0x04);
        $this->rellocate('_midiHandles_8c0fcd28', $midiHandlesPtr);
        $this->shouldRead($midiHandlesPtr, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 0, 0);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x0f);
        // Reset logo timer
        $this->shouldWrite($menuStatePtr + 0x68, 0);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 6, 0.0, 0.0, -4.5);
        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0e_PressStart_AdvancesToTimeOutWhenTimeIsUp() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0e);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0e);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 0xFFFFFFF3);

        $this->shouldRead($menuStatePtr + 0x64, 1051);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x11);

        $this->shouldCall('_FUN_8c010bae')->with(0);
        $this->shouldCall('_FUN_8c010bae')->with(1);
        $this->shouldCall('_push_fadeout_8c022b60')->with(60);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 6, 0.0, 0.0, -4.5);
        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0f_StartPressed_WaitsForTimer() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0f);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0f);

        $this->shouldRead($menuStatePtr + 0x68, 1);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);

        // Blink check
        $this->shouldRead($menuStatePtr + 0x68, 1);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 6, 0.0, 0.0, -4.5);
        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0f_StartPressed_BlinksSpriteOnEveryOtherTickWhileWaitingForTimer() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0f);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0f);

        $this->shouldRead($menuStatePtr + 0x68, 0);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);

        // Blink check
        $this->shouldRead($menuStatePtr + 0x68, 0);

        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x0f_StartPressed_AdvancesAfterTimer() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0f);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0f);

        $this->shouldRead($menuStatePtr + 0x68, 10);

        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x10);
        $this->shouldCall('_push_fadeout_8c022b60')->with(10);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);

        // Blink check
        $this->shouldRead($menuStatePtr + 0x68, 10);

        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x10_StartPressedFadeOut_WaitsForFadeOut() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x10);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x10);

        $saveNamesPtr = $this->alloc(0x4);
        $this->rellocate('_saveNames_8c044d50', $saveNamesPtr);
        $this->shouldCall('_FUN_8c019550')->with($saveNamesPtr, 3);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);

        // Blink check
        $this->shouldRead($menuStatePtr + 0x68, 0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 6, 0.0, 0.0, -4.5);

        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x10_StartPressedFadeOut_BlinksSpriteWhileWaitingForFadeOut() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x10);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x10);

        $saveNamesPtr = $this->alloc(0x4);
        $this->rellocate('_saveNames_8c044d50', $saveNamesPtr);
        $this->shouldCall('_FUN_8c019550')->with($saveNamesPtr, 3);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);

        // Blink check
        $this->shouldRead($menuStatePtr + 0x68, 1);

        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x10_StartPressedFadeOut_WaitsFor8c03bd80BeforeAdvancing() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x10);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x10);

        $saveNamesPtr = $this->alloc(0x4);
        $this->rellocate('_saveNames_8c044d50', $saveNamesPtr);
        $this->shouldCall('_FUN_8c019550')->with($saveNamesPtr, 3);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        $this->shouldReadSymbolOffset('__8c03bd80', 0, 1);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x10_StartPressedFadeOut_AdvancesWhenTimeIsUpAnd8c03bd80IsFalse() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x10);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x10);

        $saveNamesPtr = $this->alloc(0x4);
        $this->rellocate('_saveNames_8c044d50', $saveNamesPtr);
        $this->shouldCall('_FUN_8c019550')->with($saveNamesPtr, 3);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);
        $this->shouldReadSymbolOffset('__8c03bd80', 0, 0);
        $this->shouldWriteSymbolOffset('_var_8c1bb8c4', 0, 0);
        $this->shouldCall('_FUN_8c019e44')->with(0xbebacafe);

        $this->call('_task_title_8c015ab8')
            ->with(0xbebacafe, 0)
            ->run();
    }

    public function testState0x11_TimeOut_WaitsForFadeOut() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x11);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x11);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 1);

        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 5, 0.0, 0.0, -4.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 6, 0.0, 0.0, -4.5);
        // Draw flag
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 4, 302.0, 97.0, -4.5);
        // Draw bus
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 1, 180.0, 0.0, -4.0);
        // Draw title
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x0c, 2, 0.0, 0.0, -5.0);
        $this->shouldCall('_drawSprite_8c014f54')->with($menuStatePtr + 0x00, 46, 0.0, 0.0, -7.0);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x11_TimeOut_WaitsFor8c03bd80BeforeAdvancing() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x11);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x11);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);

        $this->shouldReadSymbolOffset('__8c03bd80', 0, 1);

        $this->call('_task_title_8c015ab8')
            ->with(0, 0)
            ->run();
    }

    public function testState0x11_TimeOut_AdvancesWhenFadedAnd8c03bd80IsFalse() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x11);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x11);

        $this->shouldReadSymbolOffset('_isFading_8c226568', 0, 0);
        $this->shouldReadSymbolOffset('__8c03bd80', 0, 0);
        $this->shouldCall('_FUN_8c016182');
        $this->shouldCall('_FUN_8c0159ac');

        $this->call('_task_title_8c015ab8')
            ->with(0xbebacafe, 0)
            ->run();
    }

    public function testState0x0b_BusSlide_SkipsToPressStartWhenStartIsPressed() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0b);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 1 << 3);

        $this->shouldReadSymbolOffset('_midiHandles_8c0fcd28', 0, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 0, 0);

        $this->shouldWrite($peripheralPtr + 16, 0);
        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x0e);
        $this->shouldWriteSymbolOffset('_isFading_8c226568', 0, 0);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0e);

        $this->forceStop();

        $this->call('_task_title_8c015ab8')
            ->with(0xbebacafe, 0)
            ->run();
    }

    public function testState0x0c_FlagReveal_SkipsToPressStartWhenStartIsPressed() {
        $menuStatePtr = $this->alloc(0x6c);
        $this->rellocate('_menuState_8c1bc7a8', $menuStatePtr);
        $this->shouldRead($menuStatePtr + 0x18, 0x0c);

        // peripherals[0].press (sizeof PERIPHERAL = 52)
        $peripheralPtr = $this->alloc(52);
        $this->rellocate('_peripheral_8c1ba35c', $peripheralPtr);
        $this->shouldRead($peripheralPtr + 16, 1 << 3);

        $this->shouldReadSymbolOffset('_midiHandles_8c0fcd28', 0, 0xbebacafe);
        $this->shouldCall('_sdMidiPlay')->with(0xbebacafe, 1, 0, 0);

        $this->shouldWrite($peripheralPtr + 16, 0);
        // Advance title state
        $this->shouldWrite($menuStatePtr + 0x18, 0x0e);
        $this->shouldWriteSymbolOffset('_isFading_8c226568', 0, 0);

        // Switch case
        $this->shouldRead($menuStatePtr + 0x18, 0x0e);

        $this->forceStop();

        $this->call('_task_title_8c015ab8')
            ->with(0xbebacafe, 0)
            ->run();
    }
};
