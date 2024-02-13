<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\WildcardArgument;

function fdec(float $value) {
    return unpack('L', pack('f', $value))[1];
}

return new class extends TestCase {
    public function testFUN_8c01306e_DemoIsNot2()
    {
        $matrixPtr = $this->allocRellocate('_var_matrix_8c2f8ca0', 0x04);

        $var_8c18ad28Ptr = $this->alloc(0x14);
        $this->initUint8($var_8c18ad28Ptr + 0x08, 0x10);
        $this->initUint8($var_8c18ad28Ptr + 0x09, 0x20);
        $this->initUint8($var_8c18ad28Ptr + 0x0a, 0x30);
        $this->initUint8($var_8c18ad28Ptr + 0x0b, 0x40);
        $this->initUint32($var_8c18ad28Ptr + 0x0c, fdec(42.0));
        $this->initUint32($var_8c18ad28Ptr + 0x10, fdec(43.0));

        $var_8c18ad28PtrPtr = $this->allocRellocate('_var_8c18ad28', 4);
        $this->initUint32($var_8c18ad28PtrPtr, $var_8c18ad28Ptr);

        $var_fogTable_8c18aaf8Ptr = $this->allocRellocate('_var_fogTable_8c18aaf8', 4);

        $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);
        $var_tasks_8c1ba5e8Ptr = $this->allocRellocate('_var_tasks_8c1ba5e8', 4);
        $var_tasks_8c1ba808Ptr = $this->allocRellocate('_var_tasks_8c1ba808', 4);
        $var_tasks_8c1bac28Ptr = $this->allocRellocate('_var_tasks_8c1bac28', 4);
        $var_tasks_8c1bb448Ptr = $this->allocRellocate('_var_tasks_8c1bb448', 4);

        $var_seed_8c157a64Ptr = $this->allocRellocate('_var_seed_8c157a64', 4);
        $this->initUint32($var_seed_8c157a64Ptr, 0xcafe0001);

        $var_demo_8c1bb8d0Ptr = $this->allocRellocate('_var_demo_8c1bb8d0', 4);
        $this->initUint32($var_demo_8c1bb8d0Ptr, 1);

        $task_8c012cbcPtr = $this->allocRellocate('_task_8c012cbc', 4);
        $task_8c01677ePtr = $this->allocRellocate('_task_8c01677e', 4);

        $var_8c1bb8ccPtr = $this->allocRellocate('_var_8c1bb8cc', 4);
        $var_8c22847cPtr = $this->allocRellocate('_var_8c22847c', 4);

        $this->shouldCall('_njInitMatrix')->with($matrixPtr, 16, 0);
        $this->shouldCall('_njSetBackColor')->with(0, 0, 0);
        $this->shouldCall('_njSetFogColor')->with(0x40302010);
        $this->shouldCall('_njGenerateFogTable3')->with($var_fogTable_8c18aaf8Ptr, 42.0, 43.0);
        $this->shouldCall('_njFogEnable');
        $this->shouldCall('_kmSetCheapShadowMode')->with(0x80);
        $this->shouldCall('_kmSetFogTable')->with($var_fogTable_8c18aaf8Ptr);

        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba5e8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba808Ptr, 0x20);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bac28Ptr, 0x40);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bb448Ptr, 0x20);

        // njRandomSeed
        $this->shouldCall('_srand')->with(0xcafe0001);
        $this->shouldCall('_FUN_8c012160')->with(0xcafe0001);
        $this->shouldCall('_FUN_8c0121a2')->with(0xcafe0001);
        
        $this->shouldCall('_FUN_8c0128cc')->with(1);

        $this->shouldCall('_pushTask_8c014ae8')->with($var_tasks_8c1ba3c8Ptr, $task_8c012cbcPtr, 0xffffe4, 0xFFFFE8, 0);
        $this->shouldCall('_pushTask_8c014ae8')->with($var_tasks_8c1ba5e8Ptr, $task_8c01677ePtr, 0xffffe4, 0xFFFFE8, 0);

        $this->shouldWrite($var_8c1bb8ccPtr, 0);
        $this->shouldWrite($var_8c22847cPtr, 0);

        $this->shouldCall('_FUN_8c023610');
        $this->shouldCall('_FUN_8c02845a');
        
        $this->shouldCall('_FUN_8c029920');
        
        $this->shouldCall('_FUN_8c0296d6');
        $this->shouldCall('_FUN_8c02769e');
        $this->shouldCall('_FUN_8c0222dc');
        $this->shouldCall('_FUN_8c02a6ac');
        $this->shouldCall('_FUN_8c02c46a');
        $this->shouldCall('_FUN_8c02018c');
        $this->shouldCall('_FUN_8c02d968');
        $this->shouldCall('_FUN_8c020528');

        $this->shouldCall('_pushTask_8c014ae8')->with(
            $var_tasks_8c1ba5e8Ptr,
            new WildcardArgument,
            0xffffe4,
            0xFFFFE8,
            0
        );

        $createdTask = $this->alloc(0x0c);
        $this->shouldRead(0xffffe4, $createdTask);
        $this->shouldWrite($createdTask + 0x08, 0);

        $this->shouldCall('_FUN_8c0228a2');

        $this->call('_FUN_8c01306e')->run();
    }

    public function testFUN_8c01306e_DemoIs2_8c1bb8d4Is0()
    {
        $matrixPtr = $this->allocRellocate('_var_matrix_8c2f8ca0', 0x04);

        $var_8c18ad28Ptr = $this->alloc(0x14);
        $this->initUint8($var_8c18ad28Ptr + 0x08, 0x10);
        $this->initUint8($var_8c18ad28Ptr + 0x09, 0x20);
        $this->initUint8($var_8c18ad28Ptr + 0x0a, 0x30);
        $this->initUint8($var_8c18ad28Ptr + 0x0b, 0x40);
        $this->initUint32($var_8c18ad28Ptr + 0x0c, fdec(42.0));
        $this->initUint32($var_8c18ad28Ptr + 0x10, fdec(43.0));

        $var_8c18ad28PtrPtr = $this->allocRellocate('_var_8c18ad28', 4);
        $this->initUint32($var_8c18ad28PtrPtr, $var_8c18ad28Ptr);

        $var_fogTable_8c18aaf8Ptr = $this->allocRellocate('_var_fogTable_8c18aaf8', 4);

        $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);
        $var_tasks_8c1ba5e8Ptr = $this->allocRellocate('_var_tasks_8c1ba5e8', 4);
        $var_tasks_8c1ba808Ptr = $this->allocRellocate('_var_tasks_8c1ba808', 4);
        $var_tasks_8c1bac28Ptr = $this->allocRellocate('_var_tasks_8c1bac28', 4);
        $var_tasks_8c1bb448Ptr = $this->allocRellocate('_var_tasks_8c1bb448', 4);

        $var_seed_8c157a64Ptr = $this->allocRellocate('_var_seed_8c157a64', 4);
        $this->initUint32($var_seed_8c157a64Ptr, 0xcafe0001);

        $var_demo_8c1bb8d0Ptr = $this->allocRellocate('_var_demo_8c1bb8d0', 4);
        $this->initUint32($var_demo_8c1bb8d0Ptr, 2);

        $var_8c1bb8d4Ptr = $this->allocRellocate('_var_8c1bb8d4', 4);
        $this->initUint32($var_8c1bb8d4Ptr, 0);

        $task_8c012d06Ptr = $this->allocRellocate('_task_8c012d06', 4);
        $task_8c016bf4Ptr = $this->allocRellocate('_task_8c016bf4', 4);

        $var_8c1bb8ccPtr = $this->allocRellocate('_var_8c1bb8cc', 4);
        $var_8c22847cPtr = $this->allocRellocate('_var_8c22847c', 4);

        $this->shouldCall('_njInitMatrix')->with($matrixPtr, 16, 0);
        $this->shouldCall('_njSetBackColor')->with(0, 0, 0);
        $this->shouldCall('_njSetFogColor')->with(0x40302010);
        $this->shouldCall('_njGenerateFogTable3')->with($var_fogTable_8c18aaf8Ptr, 42.0, 43.0);
        $this->shouldCall('_njFogEnable');
        $this->shouldCall('_kmSetCheapShadowMode')->with(0x80);
        $this->shouldCall('_kmSetFogTable')->with($var_fogTable_8c18aaf8Ptr);

        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba5e8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba808Ptr, 0x20);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bac28Ptr, 0x40);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bb448Ptr, 0x20);

        // njRandomSeed
        $this->shouldCall('_srand')->with(0xcafe0001);
        $this->shouldCall('_FUN_8c012160')->with(0xcafe0001);
        $this->shouldCall('_FUN_8c0121a2')->with(0xcafe0001);
        
        $this->shouldCall('_FUN_8c0128cc')->with(1);

        $this->shouldCall('_pushTask_8c014ae8')->with($var_tasks_8c1ba3c8Ptr, $task_8c012d06Ptr, 0xffffe4, 0xFFFFE8, 0);
        $this->shouldCall('_pushTask_8c014ae8')->with($var_tasks_8c1ba5e8Ptr, $task_8c016bf4Ptr, 0xffffe4, 0xFFFFE8, 0);
        $this->shouldCall('_FUN_8c025af4');

        $this->shouldWrite($var_8c1bb8ccPtr, 0);
        $this->shouldWrite($var_8c22847cPtr, 0);

        $this->shouldCall('_FUN_8c023610');
        $this->shouldCall('_FUN_8c02845a');
        
        $this->shouldCall('_FUN_8c0296d6');
        $this->shouldCall('_FUN_8c02769e');
        $this->shouldCall('_FUN_8c0222dc');
        $this->shouldCall('_FUN_8c02a6ac');
        $this->shouldCall('_FUN_8c02c46a');
        $this->shouldCall('_FUN_8c02018c');
        $this->shouldCall('_FUN_8c02d968');
        $this->shouldCall('_FUN_8c020528');

        $this->shouldCall('_pushTask_8c014ae8')->with(
            $var_tasks_8c1ba5e8Ptr,
            new WildcardArgument,
            0xffffe4,
            0xFFFFE8,
            0
        );
        $createdTask = $this->alloc(0x0c);
        $this->shouldRead(0xffffe4, $createdTask);
        $this->shouldWrite($createdTask + 0x08, 0);

        $this->shouldCall('_FUN_8c0228a2');

        $this->call('_FUN_8c01306e')->run();
    }

    public function testFUN_8c01306e_DemoIs2_8c1bb8d4Is1()
    {
        $matrixPtr = $this->allocRellocate('_var_matrix_8c2f8ca0', 0x04);

        $var_8c18ad28Ptr = $this->alloc(0x14);
        $this->initUint8($var_8c18ad28Ptr + 0x08, 0x10);
        $this->initUint8($var_8c18ad28Ptr + 0x09, 0x20);
        $this->initUint8($var_8c18ad28Ptr + 0x0a, 0x30);
        $this->initUint8($var_8c18ad28Ptr + 0x0b, 0x40);
        $this->initUint32($var_8c18ad28Ptr + 0x0c, fdec(42.0));
        $this->initUint32($var_8c18ad28Ptr + 0x10, fdec(43.0));

        $var_8c18ad28PtrPtr = $this->allocRellocate('_var_8c18ad28', 4);
        $this->initUint32($var_8c18ad28PtrPtr, $var_8c18ad28Ptr);

        $var_fogTable_8c18aaf8Ptr = $this->allocRellocate('_var_fogTable_8c18aaf8', 4);

        $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);
        $var_tasks_8c1ba5e8Ptr = $this->allocRellocate('_var_tasks_8c1ba5e8', 4);
        $var_tasks_8c1ba808Ptr = $this->allocRellocate('_var_tasks_8c1ba808', 4);
        $var_tasks_8c1bac28Ptr = $this->allocRellocate('_var_tasks_8c1bac28', 4);
        $var_tasks_8c1bb448Ptr = $this->allocRellocate('_var_tasks_8c1bb448', 4);

        $var_seed_8c157a64Ptr = $this->allocRellocate('_var_seed_8c157a64', 4);
        $this->initUint32($var_seed_8c157a64Ptr, 0xcafe0001);

        $var_demo_8c1bb8d0Ptr = $this->allocRellocate('_var_demo_8c1bb8d0', 4);
        $this->initUint32($var_demo_8c1bb8d0Ptr, 2);

        $var_8c1bb8d4Ptr = $this->allocRellocate('_var_8c1bb8d4', 4);
        $this->initUint32($var_8c1bb8d4Ptr, 1);

        $task_8c012d5aPtr = $this->allocRellocate('_task_8c012d5a', 4);
        $task_8c016bf4Ptr = $this->allocRellocate('_task_8c016bf4', 4);

        $var_8c1bb8ccPtr = $this->allocRellocate('_var_8c1bb8cc', 4);
        $var_8c22847cPtr = $this->allocRellocate('_var_8c22847c', 4);

        $this->shouldCall('_njInitMatrix')->with($matrixPtr, 16, 0);
        $this->shouldCall('_njSetBackColor')->with(0, 0, 0);
        $this->shouldCall('_njSetFogColor')->with(0x40302010);
        $this->shouldCall('_njGenerateFogTable3')->with($var_fogTable_8c18aaf8Ptr, 42.0, 43.0);
        $this->shouldCall('_njFogEnable');
        $this->shouldCall('_kmSetCheapShadowMode')->with(0x80);
        $this->shouldCall('_kmSetFogTable')->with($var_fogTable_8c18aaf8Ptr);

        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba5e8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba808Ptr, 0x20);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bac28Ptr, 0x40);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bb448Ptr, 0x20);

        // njRandomSeed
        $this->shouldCall('_srand')->with(0xcafe0001);
        $this->shouldCall('_FUN_8c012160')->with(0xcafe0001);
        $this->shouldCall('_FUN_8c0121a2')->with(0xcafe0001);
        
        $this->shouldCall('_FUN_8c0128cc')->with(1);

        $this->shouldCall('_pushTask_8c014ae8')->with($var_tasks_8c1ba3c8Ptr, $task_8c012d5aPtr, 0xffffe4, 0xFFFFE8, 0);

        $createdTask = $this->alloc(0x0c);
        $this->shouldRead(0xffffe4, $createdTask);
        $this->shouldWrite($createdTask + 0x08, 0);
        $this->shouldRead(0xffffe4, $createdTask);
        $this->shouldWrite($createdTask + 0x0c, 0);
    
        $this->shouldCall('_pushTask_8c014ae8')->with($var_tasks_8c1ba5e8Ptr, $task_8c016bf4Ptr, 0xffffe4, 0xFFFFE8, 0);
        $this->shouldCall('_FUN_8c025af4');

        $this->shouldWrite($var_8c1bb8ccPtr, 0);
        $this->shouldWrite($var_8c22847cPtr, 0);

        $this->shouldCall('_FUN_8c023610');
        $this->shouldCall('_FUN_8c02845a');
        
        $this->shouldCall('_FUN_8c0296d6');
        $this->shouldCall('_FUN_8c02769e');
        $this->shouldCall('_FUN_8c0222dc');
        $this->shouldCall('_FUN_8c02a6ac');
        $this->shouldCall('_FUN_8c02c46a');
        $this->shouldCall('_FUN_8c02018c');
        $this->shouldCall('_FUN_8c02d968');
        $this->shouldCall('_FUN_8c020528');

        $this->shouldCall('_pushTask_8c014ae8')->with(
            $var_tasks_8c1ba5e8Ptr,
            new WildcardArgument,
            0xffffe4,
            0xFFFFE8,
            0
        );
        $createdTask = $this->alloc(0x0c);
        $this->shouldRead(0xffffe4, $createdTask);
        $this->shouldWrite($createdTask + 0x08, 0);

        $this->shouldCall('_FUN_8c0228a2');

        $this->call('_FUN_8c01306e')->run();
    }

    ////// task_8c013388 //////

    public function test_task_8c013388_field0x08Is0_PvmBoolIs0()
    {
        $taskPtr = $this->alloc(0xc);

        $this->shouldCall('_getUknPvmBool_8c01432a')
            ->andReturn(0);

        $this->call('_task_8c013388')
            ->with($taskPtr, 0)
            ->run();
    }

    public function test_task_8c013388_field0x08Is0_PvmBoolIs1()
    {
        $taskPtr = $this->alloc(0xc);

        $var_loadedFooNjm_8c1bc448Ptr = $this->alloc(0x08);
        $var_loadedFooNjm_8c1bc448PtrPtr = $this->allocRellocate('_var_loadedFooNjm_8c1bc448', 0x04);
        $this->initUint32($var_loadedFooNjm_8c1bc448PtrPtr, $var_loadedFooNjm_8c1bc448Ptr);
        $this->initUint32($var_loadedFooNjm_8c1bc448Ptr + 4, 42);
        $var_8c1bc450Ptr = $this->allocRellocate('_var_8c1bc450', 4);
        $memblkSource_8c0fcd48Ptr = $this->allocRellocate('_memblkSource_8c0fcd48', 4);
        $memblkSource_8c0fcd4cPtr = $this->allocRellocate('_memblkSource_8c0fcd4c', 4);
        $nop_8c011120Ptr = $this->allocRellocate('_nop_8c011120', 4);
        $setUknPvmBool_8c014330Ptr = $this->allocRellocate('_setUknPvmBool_8c014330', 4);

        $this->shouldCall('_getUknPvmBool_8c01432a')->andReturn(1);

        $this->shouldWrite($taskPtr + 8, 1);
        $this->shouldWrite($var_8c1bc450Ptr, fdec(41));

        $this->shouldCall('_FUN_8c011f6c');
        $this->shouldCall('_requestDat_8c011182')->with("\\SOUND", "manatee.drv", $memblkSource_8c0fcd48Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SOUND", "bus.mlt", $memblkSource_8c0fcd4cPtr);
        $this->shouldCall('_resetUknPvmBool_8c014322');
        $this->shouldCall('_FUN_8c011fe0')->with($nop_8c011120Ptr, 0, 0, 0, $setUknPvmBool_8c014330Ptr);

        $this->call('_task_8c013388')
            ->with($taskPtr, 0)
            ->run();
    }

    public function test_task_8c013388_field0x08Is1_PvmBoolIs0()
    {
        $taskPtr = $this->alloc(0xc);
        $this->initUint32($taskPtr + 8, 1);

        $this->shouldCall('_getUknPvmBool_8c01432a')->andReturn(0);

        $this->call('_task_8c013388')
            ->with($taskPtr, 0)
            ->run();
    }

    public function test_task_8c013388_field0x08Is1_PvmBoolIs1()
    {
        $taskPtr = $this->alloc(0xc);
        $this->initUint32($taskPtr + 8, 1);
        $var_8c2260a8Ptr = $this->allocRellocate('_var_8c2260a8', 4);

        $this->shouldCall('_getUknPvmBool_8c01432a')->andReturn(1);

        $this->shouldCall('_FUN_8c011f7e');
        $this->shouldCall('_freeTask_8c014b66')->with($taskPtr);
        $this->shouldCall('_FUN_8c010e18');
        $this->shouldWrite($var_8c2260a8Ptr, 1);
        $this->shouldCall('_FUN_8c015fd6');

        $this->call('_task_8c013388')
            ->with($taskPtr, 0)
            ->run();
    }

    ////// njUserInit_8c0134ec //////

    public function test_njUserInit_8c0134ec_Vga_FUN_8c010924Returns1()
    {
        // Resolutions/Bindings
        $var_matrix_8c2f8ca0Ptr = $this->allocRellocate('_var_matrix_8c2f8ca0', 4);
        $var_vbuf_8c255ca0Ptr = $this->allocRellocate('_var_vbuf_8c255ca0', 4);
        $var_texbuf_8c277ca0Ptr = $this->allocRellocate('_var_texbuf_8c277ca0', 4);
        $var_tex_8c157af8Ptr = $this->allocRellocate('_var_tex_8c157af8', 4);
        $var_cachebuf_8c235ca0Ptr = $this->allocRellocate('_var_cachebuf_8c235ca0', 4);
        $var_shapebuf_8c2f84a0Ptr = $this->allocRellocate('_var_shapebuf_8c2f84a0', 4);
        $var_8c226070Ptr = $this->allocRellocate('_var_8c226070', 4);
        $var_texname_8c18acf8Ptr = $this->allocRellocate('_var_texname_8c18acf8', 4);
        $init_texlist_8c03bf44Ptr = $this->allocRellocate('_init_texlist_8c03bf44', 4);
        $var_8c1bb86cPtr = $this->allocRellocate('_var_8c1bb86c', 4);
        $var_8c1bbddcPtr = $this->allocRellocate('_var_8c1bbddc', 4);
        $var_8c1bbfdcPtr = $this->allocRellocate('_var_8c1bbfdc', 4);

        $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);
        $var_tasks_8c1ba5e8Ptr = $this->allocRellocate('_var_tasks_8c1ba5e8', 4);
        $var_tasks_8c1ba808Ptr = $this->allocRellocate('_var_tasks_8c1ba808', 4);
        $var_tasks_8c1bac28Ptr = $this->allocRellocate('_var_tasks_8c1bac28', 4);
        $var_tasks_8c1bb448Ptr = $this->allocRellocate('_var_tasks_8c1bb448', 4);

        $var_8c1bc3ecPtr = $this->allocRellocate('_var_8c1bc3ec', 4);
        $var_8c1bc3f0Ptr = $this->allocRellocate('_var_8c1bc3f0', 4);
        $var_8c1bc3f4Ptr = $this->allocRellocate('_var_8c1bc3f4', 4);

        $var_8c1bc404Ptr = $this->allocRellocate('_var_8c1bc404', 4);
        $var_8c226434Ptr = $this->allocRellocate('_var_8c226434', 4);
        $var_8c226438Ptr = $this->allocRellocate('_var_8c226438', 4);
        $var_8c228234Ptr = $this->allocRellocate('_var_8c228234', 4);
        $var_8c227e20Ptr = $this->allocRellocate('_var_8c227e20', 4);
        $var_8c227e24Ptr = $this->allocRellocate('_var_8c227e24', 4);
        $var_8c2288f8Ptr = $this->allocRellocate('_var_8c2288f8', 4);
        $var_8c1bc438Ptr = $this->allocRellocate('_var_8c1bc438', 4);
        $menuState_8c1bc7a8Ptr = $this->allocRellocate('_menuState_8c1bc7a8', 0x6c);
        $var_8c2263a8Ptr = $this->allocRellocate('_var_8c2263a8', 4);
        $var_8c1ba2e0Ptr = $this->allocRellocate('_var_8c1ba2e0', 4);
        $var_8c1ba348Ptr = $this->allocRellocate('_var_8c1ba348', 4);
        $var_8c1ba344Ptr = $this->allocRellocate('_var_8c1ba344', 4);
        $var_8c225fb0Ptr = $this->allocRellocate('_var_8c225fb0', 4);
        $var_8c1ba3c4Ptr = $this->allocRellocate('_var_8c1ba3c4', 4);
        $var_8c1bc454Ptr = $this->allocRellocate('_var_8c1bc454', 4);
        $var_8c1ba34cPtr = $this->allocRellocate('_var_8c1ba34c', 4);

        $var_8c1bb8c4Ptr = $this->allocRellocate('_var_8c1bb8c4', 4);
        $var_8c1bb8d8Ptr = $this->allocRellocate('_var_8c1bb8d8', 4);
        $var_8c157a6cPtr = $this->allocRellocate('_var_8c157a6c', 4);
        
        $var_mark_parts_dat_8c1bc41cPtr = $this->allocRellocate('_var_mark_parts_dat_8c1bc41c', 4);
        $var_mark_dat_8c1bc420Ptr = $this->allocRellocate('_var_mark_dat_8c1bc420', 4);
        $var_busstop_parts_dat_8c1bc428Ptr = $this->allocRellocate('_var_busstop_parts_dat_8c1bc428', 4);
        $var_busstop_dat_8c1bc42cPtr = $this->allocRellocate('_var_busstop_dat_8c1bc42c', 4);

        $var_8c1bc3f8Ptr = $this->allocRellocate('_var_8c1bc3f8', 4);

        $var_8c1ba1c8Ptr = $this->allocRellocate('_var_8c1ba1c8', 4);
        $var_8c2260acPtr = $this->allocRellocate('_var_8c2260ac', 4);
        $var_8c2260b8Ptr = $this->allocRellocate('_var_8c2260b8', 4);
        $var_8c2260c4Ptr = $this->allocRellocate('_var_8c2260c4', 4);

        $var_8c1bc440Ptr = $this->allocRellocate('_var_8c1bc440', 4);
        $var_8c1bc444Ptr = $this->allocRellocate('_var_8c1bc444', 4);
        $var_loadedFooNjm_8c1bc448Ptr = $this->allocRellocate('_var_loadedFooNjm_8c1bc448', 4);
        $var_8c1bc410Ptr = $this->allocRellocate('_var_8c1bc410', 4);
        $var_8c1bc414Ptr = $this->allocRellocate('_var_8c1bc414', 4);

        $nop_8c011120Ptr = $this->allocRellocate('_nop_8c011120', 4);
        $setUknPvmBool_8c014330Ptr = $this->allocRellocate('_setUknPvmBool_8c014330', 4);
        $var_8c18ad14Ptr = $this->allocRellocate('_var_8c18ad14', 4);

        /* Stack locals */
        $infoLocal = 0xffffbc;
        $createdTaskLocal = 0xffffb4;
        $createdStateLocal = 0xffffb8;

        /* Expectations */
        $this->shouldCall('_njSetTextureMemorySize')->with(0x100000);

        // SYE_CBL_CABLE_VGA
        $this->shouldCall('_syCblCheckCable')->andReturn(0);

        $this->shouldCall('_sbInitSystem_8c0149b0')
            ->with(
                0x31, // NJD_RESOLUTION_VGA
                0x00, // NJD_FRAMEBUFFER_MODE_RGB565
                2
            );

        $this->shouldCall('_njInitMatrix')->with($var_matrix_8c2f8ca0Ptr, 16, 0);
        $this->shouldCall('_njInit3D')->with($var_vbuf_8c255ca0Ptr, 2048);
        $this->shouldCall('_njInitVertexBuffer')->with(800000, 320000, 320000, 320000, 20000);
        $this->shouldCall('_njInitTextureBuffer')->with($var_texbuf_8c277ca0Ptr, 0x80800);
        $this->shouldCall('_njInitTexture')->with($var_tex_8c157af8Ptr, 3072);
        $this->shouldCall('_njInitCacheTextureBuffer')->with($var_cachebuf_8c235ca0Ptr, 0x20000);
        $this->shouldCall('_njInitShape')->with($var_shapebuf_8c2f84a0Ptr);
        $this->shouldCall('_syRtcInit');

        $this->shouldCall('_FUN_8c010924')->andReturn(1);
        $this->shouldWrite($var_8c226070Ptr, 1);
        $this->shouldCall('_setSoundMode_8c0108c0')->with(1);

        $this->shouldCall('_FUN_8c010fbe');
        $this->shouldCall('_BupInit_8c014b8c');

        $this->shouldCall('_njSetTextureInfo')
            ->with(
                $infoLocal,
                $var_texbuf_8c277ca0Ptr,
                0xb01, // NJD_TEXFMT_STRIDE | NJD_TEXFMT_RGB_565
                256, // RENDER_X
                512, // RENDER_Y
            );

        $this->shouldCall('_njSetTextureName')->with(
            $var_texname_8c18acf8Ptr,
            $infoLocal,
            999,
            0x40800000, // NJD_TEXATTR_TYPE_MEMORY|NJD_TEXATTR_GLOBALINDEX
        );

        $this->shouldCall('_njSetRenderWidth')->with(256);
        $this->shouldCall('_njLoadTexture')->with($init_texlist_8c03bf44Ptr);

        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba3c8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba5e8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba808Ptr, 0x20);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bac28Ptr, 0x40);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bb448Ptr, 0x20);

        $this->shouldWrite($var_8c1bb86cPtr, -1);

        $this->shouldCall('_FUN_8c013bbc')->with($var_8c1bbddcPtr, 0x20);
        $this->shouldCall('_FUN_8c013bbc')->with($var_8c1bbfdcPtr, 0x41);

        $this->shouldWrite($var_8c1bc3ecPtr, -1);
        $this->shouldWrite($var_8c1bc3f0Ptr, -1);
        $this->shouldWrite($var_8c1bc3f4Ptr, -1);

        $this->shouldCall('_FUN_8c02171c');
        $this->shouldCall('_FUN_8c029acc');
        $this->shouldCall('_FUN_8c02aa28');

        $this->shouldWrite($var_8c1bc404Ptr, -1);
        $this->shouldWrite($var_8c226434Ptr, -1);
        $this->shouldWrite($var_8c226438Ptr, -1);
        $this->shouldWrite($var_8c228234Ptr, -1);
        $this->shouldWrite($var_8c227e20Ptr, -1);
        $this->shouldWrite($var_8c227e24Ptr, -1);
        $this->shouldWrite($var_8c2288f8Ptr, -1);
        $this->shouldWrite($var_8c1bc438Ptr, -1);
        $this->shouldWrite($menuState_8c1bc7a8Ptr + 0x0 + 0, -1);
        $this->shouldWrite($menuState_8c1bc7a8Ptr + 0xc + 0, -1);
        $this->shouldWrite($var_8c2263a8Ptr, -1);
        $this->shouldWrite($var_8c1ba2e0Ptr, -1);
        $this->shouldWrite($var_8c1ba348Ptr, -1);
        $this->shouldWrite($var_8c1ba344Ptr, -1);
        $this->shouldWrite($var_8c225fb0Ptr, -1);
        $this->shouldWrite($var_8c1ba3c4Ptr, -1);
        $this->shouldWrite($var_8c1bc454Ptr, -1);
        $this->shouldWrite($var_8c1ba34cPtr, -1);


        $this->shouldWrite($var_8c1bb8c4Ptr, 0);
        $this->shouldWrite($var_8c1bb8d8Ptr, 100);
        $this->shouldWrite($var_8c157a6cPtr, 0);

        $this->shouldCall('_FUN_8c01c8dc');
        $this->shouldCall('_FUN_8c0189d2');
        $this->shouldCall('_njSetBorderColor')->with(0);
        $this->shouldCall('_FUN_8c01c8fc')->with(3);
        $this->shouldCall('_FUN_8c01c910');

        // FIXME: Confusing var names
        $createdTaskPtr = $this->alloc(0x0c);
        $this->initUint32($createdTaskLocal, $createdTaskPtr);

        $this->shouldCall('_pushTask_8c014ae8')->with(
            $var_tasks_8c1ba3c8Ptr,
            new WildcardArgument, // TODO: Export for testing
            $createdTaskLocal,
            $createdStateLocal,
            0
        );
        $this->shouldWrite($createdTaskPtr + 0x08, 0);

        $this->shouldCall('_FUN_8c011f36')->with(0x10, 8, 0, 8);
        $this->shouldCall('_FUN_8c011f6c');

        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "mark_parts.dat", $var_mark_parts_dat_8c1bc41cPtr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "mark.dat", $var_mark_dat_8c1bc420Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "busstop_parts.dat", $var_busstop_parts_dat_8c1bc428Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "busstop.dat", $var_busstop_dat_8c1bc42cPtr);

        $this->shouldCall('_requestPvm_8c011ac0')->with("\\SYSTEM", "loading.pvm", $var_8c1bc3f8Ptr, 1, 0x80000000);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "load_parts.dat", $var_8c1bc3f8Ptr + 4);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "loading.dat", $var_8c1bc3f8Ptr + 8);

        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "bus_font.fff", $var_8c1ba1c8Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "vm_bus.lcd", $var_8c2260acPtr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "vm_danger.lcd", $var_8c2260b8Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "now_loading.lcd", $var_8c2260c4Ptr);

        $this->shouldCall('_requestPvm_8c011ac0')->with("\\SYSTEM", "fuu.pvm", $var_8c1bc440Ptr, 1, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SYSTEM", "fuu.njd", $var_8c1bc444Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SYSTEM", "fuu.njm", $var_loadedFooNjm_8c1bc448Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SD_COMMON", "3s_bus_m2.njm", $var_8c1bc410Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SD_COMMON", "3s_bus_m2.njs", $var_8c1bc414Ptr, 0);

        $this->shouldCall('_resetUknPvmBool_8c014322');
        $this->shouldCall('_FUN_8c011fe0')->with($nop_8c011120Ptr, 0, 0, 0, $setUknPvmBool_8c014330Ptr);

        $this->shouldWrite($var_8c18ad14Ptr, 0);

        $this->shouldCall('_gdFsEntryErrFuncAll')->with(new WildcardArgument, 0);

        $this->call('_njUserInit_8c0134ec')->run();
    }

    public function test_njUserInit_8c0134ec_Vga_FUN_8c010924ReturnsNegative()
    {
        // Resolutions/Bindings
        $var_matrix_8c2f8ca0Ptr = $this->allocRellocate('_var_matrix_8c2f8ca0', 4);
        $var_vbuf_8c255ca0Ptr = $this->allocRellocate('_var_vbuf_8c255ca0', 4);
        $var_texbuf_8c277ca0Ptr = $this->allocRellocate('_var_texbuf_8c277ca0', 4);
        $var_tex_8c157af8Ptr = $this->allocRellocate('_var_tex_8c157af8', 4);
        $var_cachebuf_8c235ca0Ptr = $this->allocRellocate('_var_cachebuf_8c235ca0', 4);
        $var_shapebuf_8c2f84a0Ptr = $this->allocRellocate('_var_shapebuf_8c2f84a0', 4);
        $var_8c226070Ptr = $this->allocRellocate('_var_8c226070', 4);
        $var_texname_8c18acf8Ptr = $this->allocRellocate('_var_texname_8c18acf8', 4);
        $init_texlist_8c03bf44Ptr = $this->allocRellocate('_init_texlist_8c03bf44', 4);
        $var_8c1bb86cPtr = $this->allocRellocate('_var_8c1bb86c', 4);
        $var_8c1bbddcPtr = $this->allocRellocate('_var_8c1bbddc', 4);
        $var_8c1bbfdcPtr = $this->allocRellocate('_var_8c1bbfdc', 4);

        $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);
        $var_tasks_8c1ba5e8Ptr = $this->allocRellocate('_var_tasks_8c1ba5e8', 4);
        $var_tasks_8c1ba808Ptr = $this->allocRellocate('_var_tasks_8c1ba808', 4);
        $var_tasks_8c1bac28Ptr = $this->allocRellocate('_var_tasks_8c1bac28', 4);
        $var_tasks_8c1bb448Ptr = $this->allocRellocate('_var_tasks_8c1bb448', 4);

        $var_8c1bc3ecPtr = $this->allocRellocate('_var_8c1bc3ec', 4);
        $var_8c1bc3f0Ptr = $this->allocRellocate('_var_8c1bc3f0', 4);
        $var_8c1bc3f4Ptr = $this->allocRellocate('_var_8c1bc3f4', 4);

        $var_8c1bc404Ptr = $this->allocRellocate('_var_8c1bc404', 4);
        $var_8c226434Ptr = $this->allocRellocate('_var_8c226434', 4);
        $var_8c226438Ptr = $this->allocRellocate('_var_8c226438', 4);
        $var_8c228234Ptr = $this->allocRellocate('_var_8c228234', 4);
        $var_8c227e20Ptr = $this->allocRellocate('_var_8c227e20', 4);
        $var_8c227e24Ptr = $this->allocRellocate('_var_8c227e24', 4);
        $var_8c2288f8Ptr = $this->allocRellocate('_var_8c2288f8', 4);
        $var_8c1bc438Ptr = $this->allocRellocate('_var_8c1bc438', 4);
        $menuState_8c1bc7a8Ptr = $this->allocRellocate('_menuState_8c1bc7a8', 0x6c);
        $var_8c2263a8Ptr = $this->allocRellocate('_var_8c2263a8', 4);
        $var_8c1ba2e0Ptr = $this->allocRellocate('_var_8c1ba2e0', 4);
        $var_8c1ba348Ptr = $this->allocRellocate('_var_8c1ba348', 4);
        $var_8c1ba344Ptr = $this->allocRellocate('_var_8c1ba344', 4);
        $var_8c225fb0Ptr = $this->allocRellocate('_var_8c225fb0', 4);
        $var_8c1ba3c4Ptr = $this->allocRellocate('_var_8c1ba3c4', 4);
        $var_8c1bc454Ptr = $this->allocRellocate('_var_8c1bc454', 4);
        $var_8c1ba34cPtr = $this->allocRellocate('_var_8c1ba34c', 4);

        $var_8c1bb8c4Ptr = $this->allocRellocate('_var_8c1bb8c4', 4);
        $var_8c1bb8d8Ptr = $this->allocRellocate('_var_8c1bb8d8', 4);
        $var_8c157a6cPtr = $this->allocRellocate('_var_8c157a6c', 4);
        
        $var_mark_parts_dat_8c1bc41cPtr = $this->allocRellocate('_var_mark_parts_dat_8c1bc41c', 4);
        $var_mark_dat_8c1bc420Ptr = $this->allocRellocate('_var_mark_dat_8c1bc420', 4);
        $var_busstop_parts_dat_8c1bc428Ptr = $this->allocRellocate('_var_busstop_parts_dat_8c1bc428', 4);
        $var_busstop_dat_8c1bc42cPtr = $this->allocRellocate('_var_busstop_dat_8c1bc42c', 4);

        $var_8c1bc3f8Ptr = $this->allocRellocate('_var_8c1bc3f8', 4);

        $var_8c1ba1c8Ptr = $this->allocRellocate('_var_8c1ba1c8', 4);
        $var_8c2260acPtr = $this->allocRellocate('_var_8c2260ac', 4);
        $var_8c2260b8Ptr = $this->allocRellocate('_var_8c2260b8', 4);
        $var_8c2260c4Ptr = $this->allocRellocate('_var_8c2260c4', 4);

        $var_8c1bc440Ptr = $this->allocRellocate('_var_8c1bc440', 4);
        $var_8c1bc444Ptr = $this->allocRellocate('_var_8c1bc444', 4);
        $var_loadedFooNjm_8c1bc448Ptr = $this->allocRellocate('_var_loadedFooNjm_8c1bc448', 4);
        $var_8c1bc410Ptr = $this->allocRellocate('_var_8c1bc410', 4);
        $var_8c1bc414Ptr = $this->allocRellocate('_var_8c1bc414', 4);

        $nop_8c011120Ptr = $this->allocRellocate('_nop_8c011120', 4);
        $setUknPvmBool_8c014330Ptr = $this->allocRellocate('_setUknPvmBool_8c014330', 4);
        $var_8c18ad14Ptr = $this->allocRellocate('_var_8c18ad14', 4);

        /* Stack locals */
        $infoLocal = 0xffffbc;
        $createdTaskLocal = 0xffffb4;
        $createdStateLocal = 0xffffb8;

        /* Expectations */
        $this->shouldCall('_njSetTextureMemorySize')->with(0x100000);

        // SYE_CBL_CABLE_VGA
        $this->shouldCall('_syCblCheckCable')->andReturn(0);

        $this->shouldCall('_sbInitSystem_8c0149b0')
            ->with(
                0x31, // NJD_RESOLUTION_VGA
                0x00, // NJD_FRAMEBUFFER_MODE_RGB565
                2
            );

        $this->shouldCall('_njInitMatrix')->with($var_matrix_8c2f8ca0Ptr, 16, 0);
        $this->shouldCall('_njInit3D')->with($var_vbuf_8c255ca0Ptr, 2048);
        $this->shouldCall('_njInitVertexBuffer')->with(800000, 320000, 320000, 320000, 20000);
        $this->shouldCall('_njInitTextureBuffer')->with($var_texbuf_8c277ca0Ptr, 0x80800);
        $this->shouldCall('_njInitTexture')->with($var_tex_8c157af8Ptr, 3072);
        $this->shouldCall('_njInitCacheTextureBuffer')->with($var_cachebuf_8c235ca0Ptr, 0x20000);
        $this->shouldCall('_njInitShape')->with($var_shapebuf_8c2f84a0Ptr);
        $this->shouldCall('_syRtcInit');

        // FIXME: Handle SInt8 -1, using & 0xff for now... 
        $this->shouldCall('_FUN_8c010924')->andReturn(-1 & 0xff);
        $this->shouldWrite($var_8c226070Ptr, -1 & 0xff);
        $this->shouldCall('_setSoundMode_8c0108c0')->with(0);

        $this->shouldCall('_FUN_8c010fbe');
        $this->shouldCall('_BupInit_8c014b8c');

        $this->shouldCall('_njSetTextureInfo')
            ->with(
                $infoLocal,
                $var_texbuf_8c277ca0Ptr,
                0xb01, // NJD_TEXFMT_STRIDE | NJD_TEXFMT_RGB_565
                256, // RENDER_X
                512, // RENDER_Y
            );

        $this->shouldCall('_njSetTextureName')->with(
            $var_texname_8c18acf8Ptr,
            $infoLocal,
            999,
            0x40800000, // NJD_TEXATTR_TYPE_MEMORY|NJD_TEXATTR_GLOBALINDEX
        );

        $this->shouldCall('_njSetRenderWidth')->with(256);
        $this->shouldCall('_njLoadTexture')->with($init_texlist_8c03bf44Ptr);

        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba3c8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba5e8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba808Ptr, 0x20);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bac28Ptr, 0x40);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bb448Ptr, 0x20);

        $this->shouldWrite($var_8c1bb86cPtr, -1);

        $this->shouldCall('_FUN_8c013bbc')->with($var_8c1bbddcPtr, 0x20);
        $this->shouldCall('_FUN_8c013bbc')->with($var_8c1bbfdcPtr, 0x41);

        $this->shouldWrite($var_8c1bc3ecPtr, -1);
        $this->shouldWrite($var_8c1bc3f0Ptr, -1);
        $this->shouldWrite($var_8c1bc3f4Ptr, -1);

        $this->shouldCall('_FUN_8c02171c');
        $this->shouldCall('_FUN_8c029acc');
        $this->shouldCall('_FUN_8c02aa28');

        $this->shouldWrite($var_8c1bc404Ptr, -1);
        $this->shouldWrite($var_8c226434Ptr, -1);
        $this->shouldWrite($var_8c226438Ptr, -1);
        $this->shouldWrite($var_8c228234Ptr, -1);
        $this->shouldWrite($var_8c227e20Ptr, -1);
        $this->shouldWrite($var_8c227e24Ptr, -1);
        $this->shouldWrite($var_8c2288f8Ptr, -1);
        $this->shouldWrite($var_8c1bc438Ptr, -1);
        $this->shouldWrite($menuState_8c1bc7a8Ptr + 0x0 + 0, -1);
        $this->shouldWrite($menuState_8c1bc7a8Ptr + 0xc + 0, -1);
        $this->shouldWrite($var_8c2263a8Ptr, -1);
        $this->shouldWrite($var_8c1ba2e0Ptr, -1);
        $this->shouldWrite($var_8c1ba348Ptr, -1);
        $this->shouldWrite($var_8c1ba344Ptr, -1);
        $this->shouldWrite($var_8c225fb0Ptr, -1);
        $this->shouldWrite($var_8c1ba3c4Ptr, -1);
        $this->shouldWrite($var_8c1bc454Ptr, -1);
        $this->shouldWrite($var_8c1ba34cPtr, -1);


        $this->shouldWrite($var_8c1bb8c4Ptr, 0);
        $this->shouldWrite($var_8c1bb8d8Ptr, 100);
        $this->shouldWrite($var_8c157a6cPtr, 0);

        $this->shouldCall('_FUN_8c01c8dc');
        $this->shouldCall('_FUN_8c0189d2');
        $this->shouldCall('_njSetBorderColor')->with(0);
        $this->shouldCall('_FUN_8c01c8fc')->with(3);
        $this->shouldCall('_FUN_8c01c910');

        // FIXME: Confusing var names
        $createdTaskPtr = $this->alloc(0x0c);
        $this->initUint32($createdTaskLocal, $createdTaskPtr);

        $this->shouldCall('_pushTask_8c014ae8')->with(
            $var_tasks_8c1ba3c8Ptr,
            new WildcardArgument, // TODO: Export for testing
            $createdTaskLocal,
            $createdStateLocal,
            0
        );
        $this->shouldWrite($createdTaskPtr + 0x08, 0);

        $this->shouldCall('_FUN_8c011f36')->with(0x10, 8, 0, 8);
        $this->shouldCall('_FUN_8c011f6c');

        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "mark_parts.dat", $var_mark_parts_dat_8c1bc41cPtr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "mark.dat", $var_mark_dat_8c1bc420Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "busstop_parts.dat", $var_busstop_parts_dat_8c1bc428Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "busstop.dat", $var_busstop_dat_8c1bc42cPtr);

        $this->shouldCall('_requestPvm_8c011ac0')->with("\\SYSTEM", "loading.pvm", $var_8c1bc3f8Ptr, 1, 0x80000000);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "load_parts.dat", $var_8c1bc3f8Ptr + 4);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "loading.dat", $var_8c1bc3f8Ptr + 8);

        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "bus_font.fff", $var_8c1ba1c8Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "vm_bus.lcd", $var_8c2260acPtr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "vm_danger.lcd", $var_8c2260b8Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "now_loading.lcd", $var_8c2260c4Ptr);

        $this->shouldCall('_requestPvm_8c011ac0')->with("\\SYSTEM", "fuu.pvm", $var_8c1bc440Ptr, 1, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SYSTEM", "fuu.njd", $var_8c1bc444Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SYSTEM", "fuu.njm", $var_loadedFooNjm_8c1bc448Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SD_COMMON", "3s_bus_m2.njm", $var_8c1bc410Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SD_COMMON", "3s_bus_m2.njs", $var_8c1bc414Ptr, 0);

        $this->shouldCall('_resetUknPvmBool_8c014322');
        $this->shouldCall('_FUN_8c011fe0')->with($nop_8c011120Ptr, 0, 0, 0, $setUknPvmBool_8c014330Ptr);

        $this->shouldWrite($var_8c18ad14Ptr, 0);

        $this->shouldCall('_gdFsEntryErrFuncAll')->with(new WildcardArgument, 0);

        $this->call('_njUserInit_8c0134ec')->run();
    }

    public function test_njUserInit_8c0134ec_Ntsci_FUN_8c010924Returns1()
    {
        // Resolutions/Bindings
        $var_matrix_8c2f8ca0Ptr = $this->allocRellocate('_var_matrix_8c2f8ca0', 4);
        $var_vbuf_8c255ca0Ptr = $this->allocRellocate('_var_vbuf_8c255ca0', 4);
        $var_texbuf_8c277ca0Ptr = $this->allocRellocate('_var_texbuf_8c277ca0', 4);
        $var_tex_8c157af8Ptr = $this->allocRellocate('_var_tex_8c157af8', 4);
        $var_cachebuf_8c235ca0Ptr = $this->allocRellocate('_var_cachebuf_8c235ca0', 4);
        $var_shapebuf_8c2f84a0Ptr = $this->allocRellocate('_var_shapebuf_8c2f84a0', 4);
        $var_8c226070Ptr = $this->allocRellocate('_var_8c226070', 4);
        $var_texname_8c18acf8Ptr = $this->allocRellocate('_var_texname_8c18acf8', 4);
        $init_texlist_8c03bf44Ptr = $this->allocRellocate('_init_texlist_8c03bf44', 4);
        $var_8c1bb86cPtr = $this->allocRellocate('_var_8c1bb86c', 4);
        $var_8c1bbddcPtr = $this->allocRellocate('_var_8c1bbddc', 4);
        $var_8c1bbfdcPtr = $this->allocRellocate('_var_8c1bbfdc', 4);

        $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);
        $var_tasks_8c1ba5e8Ptr = $this->allocRellocate('_var_tasks_8c1ba5e8', 4);
        $var_tasks_8c1ba808Ptr = $this->allocRellocate('_var_tasks_8c1ba808', 4);
        $var_tasks_8c1bac28Ptr = $this->allocRellocate('_var_tasks_8c1bac28', 4);
        $var_tasks_8c1bb448Ptr = $this->allocRellocate('_var_tasks_8c1bb448', 4);

        $var_8c1bc3ecPtr = $this->allocRellocate('_var_8c1bc3ec', 4);
        $var_8c1bc3f0Ptr = $this->allocRellocate('_var_8c1bc3f0', 4);
        $var_8c1bc3f4Ptr = $this->allocRellocate('_var_8c1bc3f4', 4);

        $var_8c1bc404Ptr = $this->allocRellocate('_var_8c1bc404', 4);
        $var_8c226434Ptr = $this->allocRellocate('_var_8c226434', 4);
        $var_8c226438Ptr = $this->allocRellocate('_var_8c226438', 4);
        $var_8c228234Ptr = $this->allocRellocate('_var_8c228234', 4);
        $var_8c227e20Ptr = $this->allocRellocate('_var_8c227e20', 4);
        $var_8c227e24Ptr = $this->allocRellocate('_var_8c227e24', 4);
        $var_8c2288f8Ptr = $this->allocRellocate('_var_8c2288f8', 4);
        $var_8c1bc438Ptr = $this->allocRellocate('_var_8c1bc438', 4);
        $menuState_8c1bc7a8Ptr = $this->allocRellocate('_menuState_8c1bc7a8', 0x6c);
        $var_8c2263a8Ptr = $this->allocRellocate('_var_8c2263a8', 4);
        $var_8c1ba2e0Ptr = $this->allocRellocate('_var_8c1ba2e0', 4);
        $var_8c1ba348Ptr = $this->allocRellocate('_var_8c1ba348', 4);
        $var_8c1ba344Ptr = $this->allocRellocate('_var_8c1ba344', 4);
        $var_8c225fb0Ptr = $this->allocRellocate('_var_8c225fb0', 4);
        $var_8c1ba3c4Ptr = $this->allocRellocate('_var_8c1ba3c4', 4);
        $var_8c1bc454Ptr = $this->allocRellocate('_var_8c1bc454', 4);
        $var_8c1ba34cPtr = $this->allocRellocate('_var_8c1ba34c', 4);

        $var_8c1bb8c4Ptr = $this->allocRellocate('_var_8c1bb8c4', 4);
        $var_8c1bb8d8Ptr = $this->allocRellocate('_var_8c1bb8d8', 4);
        $var_8c157a6cPtr = $this->allocRellocate('_var_8c157a6c', 4);
        
        $var_mark_parts_dat_8c1bc41cPtr = $this->allocRellocate('_var_mark_parts_dat_8c1bc41c', 4);
        $var_mark_dat_8c1bc420Ptr = $this->allocRellocate('_var_mark_dat_8c1bc420', 4);
        $var_busstop_parts_dat_8c1bc428Ptr = $this->allocRellocate('_var_busstop_parts_dat_8c1bc428', 4);
        $var_busstop_dat_8c1bc42cPtr = $this->allocRellocate('_var_busstop_dat_8c1bc42c', 4);

        $var_8c1bc3f8Ptr = $this->allocRellocate('_var_8c1bc3f8', 4);

        $var_8c1ba1c8Ptr = $this->allocRellocate('_var_8c1ba1c8', 4);
        $var_8c2260acPtr = $this->allocRellocate('_var_8c2260ac', 4);
        $var_8c2260b8Ptr = $this->allocRellocate('_var_8c2260b8', 4);
        $var_8c2260c4Ptr = $this->allocRellocate('_var_8c2260c4', 4);

        $var_8c1bc440Ptr = $this->allocRellocate('_var_8c1bc440', 4);
        $var_8c1bc444Ptr = $this->allocRellocate('_var_8c1bc444', 4);
        $var_loadedFooNjm_8c1bc448Ptr = $this->allocRellocate('_var_loadedFooNjm_8c1bc448', 4);
        $var_8c1bc410Ptr = $this->allocRellocate('_var_8c1bc410', 4);
        $var_8c1bc414Ptr = $this->allocRellocate('_var_8c1bc414', 4);

        $nop_8c011120Ptr = $this->allocRellocate('_nop_8c011120', 4);
        $setUknPvmBool_8c014330Ptr = $this->allocRellocate('_setUknPvmBool_8c014330', 4);
        $var_8c18ad14Ptr = $this->allocRellocate('_var_8c18ad14', 4);

        /* Stack locals */
        $infoLocal = 0xffffbc;
        $createdTaskLocal = 0xffffb4;
        $createdStateLocal = 0xffffb8;

        /* Expectations */
        $this->shouldCall('_njSetTextureMemorySize')->with(0x100000);

        // SYE_CBL_CABLE_NTSC
        $this->shouldCall('_syCblCheckCable')->andReturn(3);
        
        $this->shouldCall('_sbInitSystem_8c0149b0')
        ->with(
            0x38, // NJD_RESOLUTION_640x480_NTSCNI
            0x00, // NJD_FRAMEBUFFER_MODE_RGB565
            2
        );
        $this->shouldCall('_njSetAspect')->with(1.0, 0.91);

        $this->shouldCall('_njInitMatrix')->with($var_matrix_8c2f8ca0Ptr, 16, 0);
        $this->shouldCall('_njInit3D')->with($var_vbuf_8c255ca0Ptr, 2048);
        $this->shouldCall('_njInitVertexBuffer')->with(800000, 320000, 320000, 320000, 20000);
        $this->shouldCall('_njInitTextureBuffer')->with($var_texbuf_8c277ca0Ptr, 0x80800);
        $this->shouldCall('_njInitTexture')->with($var_tex_8c157af8Ptr, 3072);
        $this->shouldCall('_njInitCacheTextureBuffer')->with($var_cachebuf_8c235ca0Ptr, 0x20000);
        $this->shouldCall('_njInitShape')->with($var_shapebuf_8c2f84a0Ptr);
        $this->shouldCall('_syRtcInit');

        $this->shouldCall('_FUN_8c010924')->andReturn(1);
        $this->shouldWrite($var_8c226070Ptr, 1);
        $this->shouldCall('_setSoundMode_8c0108c0')->with(1);

        $this->shouldCall('_FUN_8c010fbe');
        $this->shouldCall('_BupInit_8c014b8c');

        $this->shouldCall('_njSetTextureInfo')
            ->with(
                $infoLocal,
                $var_texbuf_8c277ca0Ptr,
                0xb01, // NJD_TEXFMT_STRIDE | NJD_TEXFMT_RGB_565
                256, // RENDER_X
                512, // RENDER_Y
            );

        $this->shouldCall('_njSetTextureName')->with(
            $var_texname_8c18acf8Ptr,
            $infoLocal,
            999,
            0x40800000, // NJD_TEXATTR_TYPE_MEMORY|NJD_TEXATTR_GLOBALINDEX
        );

        $this->shouldCall('_njSetRenderWidth')->with(256);
        $this->shouldCall('_njLoadTexture')->with($init_texlist_8c03bf44Ptr);

        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba3c8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba5e8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba808Ptr, 0x20);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bac28Ptr, 0x40);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bb448Ptr, 0x20);

        $this->shouldWrite($var_8c1bb86cPtr, -1);

        $this->shouldCall('_FUN_8c013bbc')->with($var_8c1bbddcPtr, 0x20);
        $this->shouldCall('_FUN_8c013bbc')->with($var_8c1bbfdcPtr, 0x41);

        $this->shouldWrite($var_8c1bc3ecPtr, -1);
        $this->shouldWrite($var_8c1bc3f0Ptr, -1);
        $this->shouldWrite($var_8c1bc3f4Ptr, -1);

        $this->shouldCall('_FUN_8c02171c');
        $this->shouldCall('_FUN_8c029acc');
        $this->shouldCall('_FUN_8c02aa28');

        $this->shouldWrite($var_8c1bc404Ptr, -1);
        $this->shouldWrite($var_8c226434Ptr, -1);
        $this->shouldWrite($var_8c226438Ptr, -1);
        $this->shouldWrite($var_8c228234Ptr, -1);
        $this->shouldWrite($var_8c227e20Ptr, -1);
        $this->shouldWrite($var_8c227e24Ptr, -1);
        $this->shouldWrite($var_8c2288f8Ptr, -1);
        $this->shouldWrite($var_8c1bc438Ptr, -1);
        $this->shouldWrite($menuState_8c1bc7a8Ptr + 0x0 + 0, -1);
        $this->shouldWrite($menuState_8c1bc7a8Ptr + 0xc + 0, -1);
        $this->shouldWrite($var_8c2263a8Ptr, -1);
        $this->shouldWrite($var_8c1ba2e0Ptr, -1);
        $this->shouldWrite($var_8c1ba348Ptr, -1);
        $this->shouldWrite($var_8c1ba344Ptr, -1);
        $this->shouldWrite($var_8c225fb0Ptr, -1);
        $this->shouldWrite($var_8c1ba3c4Ptr, -1);
        $this->shouldWrite($var_8c1bc454Ptr, -1);
        $this->shouldWrite($var_8c1ba34cPtr, -1);


        $this->shouldWrite($var_8c1bb8c4Ptr, 0);
        $this->shouldWrite($var_8c1bb8d8Ptr, 100);
        $this->shouldWrite($var_8c157a6cPtr, 0);

        $this->shouldCall('_FUN_8c01c8dc');
        $this->shouldCall('_FUN_8c0189d2');
        $this->shouldCall('_njSetBorderColor')->with(0);
        $this->shouldCall('_FUN_8c01c8fc')->with(3);
        $this->shouldCall('_FUN_8c01c910');

        // FIXME: Confusing var names
        $createdTaskPtr = $this->alloc(0x0c);
        $this->initUint32($createdTaskLocal, $createdTaskPtr);

        $this->shouldCall('_pushTask_8c014ae8')->with(
            $var_tasks_8c1ba3c8Ptr,
            new WildcardArgument, // TODO: Export for testing
            $createdTaskLocal,
            $createdStateLocal,
            0
        );
        $this->shouldWrite($createdTaskPtr + 0x08, 0);

        $this->shouldCall('_FUN_8c011f36')->with(0x10, 8, 0, 8);
        $this->shouldCall('_FUN_8c011f6c');

        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "mark_parts.dat", $var_mark_parts_dat_8c1bc41cPtr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "mark.dat", $var_mark_dat_8c1bc420Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "busstop_parts.dat", $var_busstop_parts_dat_8c1bc428Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "busstop.dat", $var_busstop_dat_8c1bc42cPtr);

        $this->shouldCall('_requestPvm_8c011ac0')->with("\\SYSTEM", "loading.pvm", $var_8c1bc3f8Ptr, 1, 0x80000000);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "load_parts.dat", $var_8c1bc3f8Ptr + 4);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "loading.dat", $var_8c1bc3f8Ptr + 8);

        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "bus_font.fff", $var_8c1ba1c8Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "vm_bus.lcd", $var_8c2260acPtr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "vm_danger.lcd", $var_8c2260b8Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "now_loading.lcd", $var_8c2260c4Ptr);

        $this->shouldCall('_requestPvm_8c011ac0')->with("\\SYSTEM", "fuu.pvm", $var_8c1bc440Ptr, 1, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SYSTEM", "fuu.njd", $var_8c1bc444Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SYSTEM", "fuu.njm", $var_loadedFooNjm_8c1bc448Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SD_COMMON", "3s_bus_m2.njm", $var_8c1bc410Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SD_COMMON", "3s_bus_m2.njs", $var_8c1bc414Ptr, 0);

        $this->shouldCall('_resetUknPvmBool_8c014322');
        $this->shouldCall('_FUN_8c011fe0')->with($nop_8c011120Ptr, 0, 0, 0, $setUknPvmBool_8c014330Ptr);

        $this->shouldWrite($var_8c18ad14Ptr, 0);

        $this->shouldCall('_gdFsEntryErrFuncAll')->with(new WildcardArgument, 0);

        $this->call('_njUserInit_8c0134ec')->run();
    }

    public function test_njUserInit_8c0134ec_Ntsci_FUN_8c010924ReturnsNegative()
    {
        // Resolutions/Bindings
        $var_matrix_8c2f8ca0Ptr = $this->allocRellocate('_var_matrix_8c2f8ca0', 4);
        $var_vbuf_8c255ca0Ptr = $this->allocRellocate('_var_vbuf_8c255ca0', 4);
        $var_texbuf_8c277ca0Ptr = $this->allocRellocate('_var_texbuf_8c277ca0', 4);
        $var_tex_8c157af8Ptr = $this->allocRellocate('_var_tex_8c157af8', 4);
        $var_cachebuf_8c235ca0Ptr = $this->allocRellocate('_var_cachebuf_8c235ca0', 4);
        $var_shapebuf_8c2f84a0Ptr = $this->allocRellocate('_var_shapebuf_8c2f84a0', 4);
        $var_8c226070Ptr = $this->allocRellocate('_var_8c226070', 4);
        $var_texname_8c18acf8Ptr = $this->allocRellocate('_var_texname_8c18acf8', 4);
        $init_texlist_8c03bf44Ptr = $this->allocRellocate('_init_texlist_8c03bf44', 4);
        $var_8c1bb86cPtr = $this->allocRellocate('_var_8c1bb86c', 4);
        $var_8c1bbddcPtr = $this->allocRellocate('_var_8c1bbddc', 4);
        $var_8c1bbfdcPtr = $this->allocRellocate('_var_8c1bbfdc', 4);

        $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);
        $var_tasks_8c1ba5e8Ptr = $this->allocRellocate('_var_tasks_8c1ba5e8', 4);
        $var_tasks_8c1ba808Ptr = $this->allocRellocate('_var_tasks_8c1ba808', 4);
        $var_tasks_8c1bac28Ptr = $this->allocRellocate('_var_tasks_8c1bac28', 4);
        $var_tasks_8c1bb448Ptr = $this->allocRellocate('_var_tasks_8c1bb448', 4);

        $var_8c1bc3ecPtr = $this->allocRellocate('_var_8c1bc3ec', 4);
        $var_8c1bc3f0Ptr = $this->allocRellocate('_var_8c1bc3f0', 4);
        $var_8c1bc3f4Ptr = $this->allocRellocate('_var_8c1bc3f4', 4);

        $var_8c1bc404Ptr = $this->allocRellocate('_var_8c1bc404', 4);
        $var_8c226434Ptr = $this->allocRellocate('_var_8c226434', 4);
        $var_8c226438Ptr = $this->allocRellocate('_var_8c226438', 4);
        $var_8c228234Ptr = $this->allocRellocate('_var_8c228234', 4);
        $var_8c227e20Ptr = $this->allocRellocate('_var_8c227e20', 4);
        $var_8c227e24Ptr = $this->allocRellocate('_var_8c227e24', 4);
        $var_8c2288f8Ptr = $this->allocRellocate('_var_8c2288f8', 4);
        $var_8c1bc438Ptr = $this->allocRellocate('_var_8c1bc438', 4);
        $menuState_8c1bc7a8Ptr = $this->allocRellocate('_menuState_8c1bc7a8', 0x6c);
        $var_8c2263a8Ptr = $this->allocRellocate('_var_8c2263a8', 4);
        $var_8c1ba2e0Ptr = $this->allocRellocate('_var_8c1ba2e0', 4);
        $var_8c1ba348Ptr = $this->allocRellocate('_var_8c1ba348', 4);
        $var_8c1ba344Ptr = $this->allocRellocate('_var_8c1ba344', 4);
        $var_8c225fb0Ptr = $this->allocRellocate('_var_8c225fb0', 4);
        $var_8c1ba3c4Ptr = $this->allocRellocate('_var_8c1ba3c4', 4);
        $var_8c1bc454Ptr = $this->allocRellocate('_var_8c1bc454', 4);
        $var_8c1ba34cPtr = $this->allocRellocate('_var_8c1ba34c', 4);

        $var_8c1bb8c4Ptr = $this->allocRellocate('_var_8c1bb8c4', 4);
        $var_8c1bb8d8Ptr = $this->allocRellocate('_var_8c1bb8d8', 4);
        $var_8c157a6cPtr = $this->allocRellocate('_var_8c157a6c', 4);
        
        $var_mark_parts_dat_8c1bc41cPtr = $this->allocRellocate('_var_mark_parts_dat_8c1bc41c', 4);
        $var_mark_dat_8c1bc420Ptr = $this->allocRellocate('_var_mark_dat_8c1bc420', 4);
        $var_busstop_parts_dat_8c1bc428Ptr = $this->allocRellocate('_var_busstop_parts_dat_8c1bc428', 4);
        $var_busstop_dat_8c1bc42cPtr = $this->allocRellocate('_var_busstop_dat_8c1bc42c', 4);

        $var_8c1bc3f8Ptr = $this->allocRellocate('_var_8c1bc3f8', 4);

        $var_8c1ba1c8Ptr = $this->allocRellocate('_var_8c1ba1c8', 4);
        $var_8c2260acPtr = $this->allocRellocate('_var_8c2260ac', 4);
        $var_8c2260b8Ptr = $this->allocRellocate('_var_8c2260b8', 4);
        $var_8c2260c4Ptr = $this->allocRellocate('_var_8c2260c4', 4);

        $var_8c1bc440Ptr = $this->allocRellocate('_var_8c1bc440', 4);
        $var_8c1bc444Ptr = $this->allocRellocate('_var_8c1bc444', 4);
        $var_loadedFooNjm_8c1bc448Ptr = $this->allocRellocate('_var_loadedFooNjm_8c1bc448', 4);
        $var_8c1bc410Ptr = $this->allocRellocate('_var_8c1bc410', 4);
        $var_8c1bc414Ptr = $this->allocRellocate('_var_8c1bc414', 4);

        $nop_8c011120Ptr = $this->allocRellocate('_nop_8c011120', 4);
        $setUknPvmBool_8c014330Ptr = $this->allocRellocate('_setUknPvmBool_8c014330', 4);
        $var_8c18ad14Ptr = $this->allocRellocate('_var_8c18ad14', 4);

        /* Stack locals */
        $infoLocal = 0xffffbc;
        $createdTaskLocal = 0xffffb4;
        $createdStateLocal = 0xffffb8;

        /* Expectations */
        $this->shouldCall('_njSetTextureMemorySize')->with(0x100000);

        // SYE_CBL_CABLE_NTSC
        $this->shouldCall('_syCblCheckCable')->andReturn(3);
        
        $this->shouldCall('_sbInitSystem_8c0149b0')
        ->with(
            0x38, // NJD_RESOLUTION_640x480_NTSCNI
            0x00, // NJD_FRAMEBUFFER_MODE_RGB565
            2
        );
        $this->shouldCall('_njSetAspect')->with(1.0, 0.91);

        $this->shouldCall('_njInitMatrix')->with($var_matrix_8c2f8ca0Ptr, 16, 0);
        $this->shouldCall('_njInit3D')->with($var_vbuf_8c255ca0Ptr, 2048);
        $this->shouldCall('_njInitVertexBuffer')->with(800000, 320000, 320000, 320000, 20000);
        $this->shouldCall('_njInitTextureBuffer')->with($var_texbuf_8c277ca0Ptr, 0x80800);
        $this->shouldCall('_njInitTexture')->with($var_tex_8c157af8Ptr, 3072);
        $this->shouldCall('_njInitCacheTextureBuffer')->with($var_cachebuf_8c235ca0Ptr, 0x20000);
        $this->shouldCall('_njInitShape')->with($var_shapebuf_8c2f84a0Ptr);
        $this->shouldCall('_syRtcInit');

        // FIXME andReturn(-1) or andReturn(new SInt8(-1))?
        $this->shouldCall('_FUN_8c010924')->andReturn(-1 & 0xff);
        $this->shouldWrite($var_8c226070Ptr, -1 & 0xff);
        $this->shouldCall('_setSoundMode_8c0108c0')->with(0);

        $this->shouldCall('_FUN_8c010fbe');
        $this->shouldCall('_BupInit_8c014b8c');

        $this->shouldCall('_njSetTextureInfo')
            ->with(
                $infoLocal,
                $var_texbuf_8c277ca0Ptr,
                0xb01, // NJD_TEXFMT_STRIDE | NJD_TEXFMT_RGB_565
                256, // RENDER_X
                512, // RENDER_Y
            );

        $this->shouldCall('_njSetTextureName')->with(
            $var_texname_8c18acf8Ptr,
            $infoLocal,
            999,
            0x40800000, // NJD_TEXATTR_TYPE_MEMORY|NJD_TEXATTR_GLOBALINDEX
        );

        $this->shouldCall('_njSetRenderWidth')->with(256);
        $this->shouldCall('_njLoadTexture')->with($init_texlist_8c03bf44Ptr);

        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba3c8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba5e8Ptr, 0x10);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1ba808Ptr, 0x20);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bac28Ptr, 0x40);
        $this->shouldCall('_clearTasks_8c014a9c')->with($var_tasks_8c1bb448Ptr, 0x20);

        $this->shouldWrite($var_8c1bb86cPtr, -1);

        $this->shouldCall('_FUN_8c013bbc')->with($var_8c1bbddcPtr, 0x20);
        $this->shouldCall('_FUN_8c013bbc')->with($var_8c1bbfdcPtr, 0x41);

        $this->shouldWrite($var_8c1bc3ecPtr, -1);
        $this->shouldWrite($var_8c1bc3f0Ptr, -1);
        $this->shouldWrite($var_8c1bc3f4Ptr, -1);

        $this->shouldCall('_FUN_8c02171c');
        $this->shouldCall('_FUN_8c029acc');
        $this->shouldCall('_FUN_8c02aa28');

        $this->shouldWrite($var_8c1bc404Ptr, -1);
        $this->shouldWrite($var_8c226434Ptr, -1);
        $this->shouldWrite($var_8c226438Ptr, -1);
        $this->shouldWrite($var_8c228234Ptr, -1);
        $this->shouldWrite($var_8c227e20Ptr, -1);
        $this->shouldWrite($var_8c227e24Ptr, -1);
        $this->shouldWrite($var_8c2288f8Ptr, -1);
        $this->shouldWrite($var_8c1bc438Ptr, -1);
        $this->shouldWrite($menuState_8c1bc7a8Ptr + 0x0 + 0, -1);
        $this->shouldWrite($menuState_8c1bc7a8Ptr + 0xc + 0, -1);
        $this->shouldWrite($var_8c2263a8Ptr, -1);
        $this->shouldWrite($var_8c1ba2e0Ptr, -1);
        $this->shouldWrite($var_8c1ba348Ptr, -1);
        $this->shouldWrite($var_8c1ba344Ptr, -1);
        $this->shouldWrite($var_8c225fb0Ptr, -1);
        $this->shouldWrite($var_8c1ba3c4Ptr, -1);
        $this->shouldWrite($var_8c1bc454Ptr, -1);
        $this->shouldWrite($var_8c1ba34cPtr, -1);


        $this->shouldWrite($var_8c1bb8c4Ptr, 0);
        $this->shouldWrite($var_8c1bb8d8Ptr, 100);
        $this->shouldWrite($var_8c157a6cPtr, 0);

        $this->shouldCall('_FUN_8c01c8dc');
        $this->shouldCall('_FUN_8c0189d2');
        $this->shouldCall('_njSetBorderColor')->with(0);
        $this->shouldCall('_FUN_8c01c8fc')->with(3);
        $this->shouldCall('_FUN_8c01c910');

        // FIXME: Confusing var names
        $createdTaskPtr = $this->alloc(0x0c);
        $this->initUint32($createdTaskLocal, $createdTaskPtr);

        $this->shouldCall('_pushTask_8c014ae8')->with(
            $var_tasks_8c1ba3c8Ptr,
            new WildcardArgument, // TODO: Export for testing
            $createdTaskLocal,
            $createdStateLocal,
            0
        );
        $this->shouldWrite($createdTaskPtr + 0x08, 0);

        $this->shouldCall('_FUN_8c011f36')->with(0x10, 8, 0, 8);
        $this->shouldCall('_FUN_8c011f6c');

        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "mark_parts.dat", $var_mark_parts_dat_8c1bc41cPtr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "mark.dat", $var_mark_dat_8c1bc420Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "busstop_parts.dat", $var_busstop_parts_dat_8c1bc428Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "busstop.dat", $var_busstop_dat_8c1bc42cPtr);

        $this->shouldCall('_requestPvm_8c011ac0')->with("\\SYSTEM", "loading.pvm", $var_8c1bc3f8Ptr, 1, 0x80000000);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "load_parts.dat", $var_8c1bc3f8Ptr + 4);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "loading.dat", $var_8c1bc3f8Ptr + 8);

        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "bus_font.fff", $var_8c1ba1c8Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "vm_bus.lcd", $var_8c2260acPtr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "vm_danger.lcd", $var_8c2260b8Ptr);
        $this->shouldCall('_requestDat_8c011182')->with("\\SYSTEM", "now_loading.lcd", $var_8c2260c4Ptr);

        $this->shouldCall('_requestPvm_8c011ac0')->with("\\SYSTEM", "fuu.pvm", $var_8c1bc440Ptr, 1, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SYSTEM", "fuu.njd", $var_8c1bc444Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SYSTEM", "fuu.njm", $var_loadedFooNjm_8c1bc448Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SD_COMMON", "3s_bus_m2.njm", $var_8c1bc410Ptr, 0);
        $this->shouldCall('_requestNj_8c011492')->with("\\SD_COMMON", "3s_bus_m2.njs", $var_8c1bc414Ptr, 0);

        $this->shouldCall('_resetUknPvmBool_8c014322');
        $this->shouldCall('_FUN_8c011fe0')->with($nop_8c011120Ptr, 0, 0, 0, $setUknPvmBool_8c014330Ptr);

        $this->shouldWrite($var_8c18ad14Ptr, 0);

        $this->shouldCall('_gdFsEntryErrFuncAll')->with(new WildcardArgument, 0);

        $this->call('_njUserInit_8c0134ec')->run();
    }

    ////// njUserMain_8c01392e //////

    public function test_njUserMain_8c01392e_happyPath()
    {
        $init_8c03bd80Ptr = $this->allocRellocate('_init_8c03bd80', 4);
        $var_8c157a60Ptr = $this->allocRellocate('_var_8c157a60', 4);
        $init_8c03bfa8Ptr = $this->allocRellocate('_init_8c03bfa8', 4);
        $var_vibport_8c1ba354Ptr = $this->allocRellocate('_var_vibport_8c1ba354', 4);
        $this->initUint32($var_vibport_8c1ba354Ptr, 0xbebacafe);
        $var_8c18ad14Ptr = $this->allocRellocate('_var_8c18ad14', 4);
        $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);

        $this->shouldRead($init_8c03bd80Ptr, 0);
        $this->shouldRead($var_8c157a60Ptr, 0);
        $this->shouldRead($init_8c03bfa8Ptr, 1);

        $this->shouldCall('_gdFsGetSysHn')->andReturn(0xbeba0001);
        // GDD_STAT_IDLE
        $this->shouldCall('_gdFsGetStat')->with(0xbeba0001)->andReturn(0);
        $this->shouldWrite($init_8c03bfa8Ptr, 0);

        // GDD_DRVSTAT_BUSY
        $this->shouldCall('_gdFsGetDrvStat')->andReturn(0x00);

        // GDD_DRVSTAT_BUSY
        $this->shouldCall('_gdFsGetDrvStat')->andReturn(0x00);

        $this->shouldCall('_gdFsReqDrvStat');
        
        $this->shouldRead($var_8c18ad14Ptr, 0);
        
        $this->shouldCall('_execTasks_8c014b42')->with($var_tasks_8c1ba3c8Ptr);

        $this->call('_njUserMain_8c01392e')->shouldReturn(0)->run();
    }

    public function test_njUserMain_8c01392e_block1_ok()
    {
        $init_8c03bd80Ptr = $this->allocRellocate('_init_8c03bd80', 4);
        $init_8c03bd84Ptr = $this->allocRellocate('_init_8c03bd84', 4);
        $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);

        $this->shouldRead($init_8c03bd80Ptr, 1);
        $this->shouldRead($init_8c03bd84Ptr, 1);

        $this->shouldCall('_execTasks_8c014b42')->with($var_tasks_8c1ba3c8Ptr);

        $this->call('_njUserMain_8c01392e')->shouldReturn(0)->run();
    }

    public function test_njUserMain_8c01392e_block1_fail_noVib()
    {
        $init_8c03bd80Ptr = $this->allocRellocate('_init_8c03bd80', 4);
        $init_8c03bd84Ptr = $this->allocRellocate('_init_8c03bd84', 4);
        $var_vibport_8c1ba354Ptr = $this->allocRellocate('_var_vibport_8c1ba354', 4);

        $this->shouldRead($init_8c03bd80Ptr, 1);
        $this->shouldRead($init_8c03bd84Ptr, 0);
        $this->shouldRead($var_vibport_8c1ba354Ptr, -1);

        // FIXME: -1 & 0xffffffff
        $this->call('_njUserMain_8c01392e')->shouldReturn(-1 & 0xffffffff)->run();
    }

    public function test_njUserMain_8c01392e_block1_fail_vib()
    {
        $init_8c03bd80Ptr = $this->allocRellocate('_init_8c03bd80', 4);
        $init_8c03bd84Ptr = $this->allocRellocate('_init_8c03bd84', 4);
        $var_vibport_8c1ba354Ptr = $this->allocRellocate('_var_vibport_8c1ba354', 4);
        $this->initUint32($var_vibport_8c1ba354Ptr, 0xbebacafe);

        $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);

        $this->shouldRead($init_8c03bd80Ptr, 1);
        $this->shouldRead($init_8c03bd84Ptr, 0);
        $this->shouldRead($var_vibport_8c1ba354Ptr, 0xbebacafe);

        $this->shouldCall('_pdVibMxStop')->with(0xbebacafe);

        // FIXME: -1 & 0xffffffff
        $this->call('_njUserMain_8c01392e')->shouldReturn(-1 & 0xffffffff)->run();
    }

    // public function test_njUserMain_8c01392e_0_0_0_idle_open_vib()
    // {
    //     $init_8c03bd80Ptr = $this->allocRellocate('_init_8c03bd80', 4);
    //     $var_8c157a60Ptr = $this->allocRellocate('_var_8c157a60', 4);
    //     $init_8c03bfa8Ptr = $this->allocRellocate('_init_8c03bfa8', 4);
    //     $var_vibport_8c1ba354Ptr = $this->allocRellocate('_var_vibport_8c1ba354', 4);
    //     $this->initUint32($var_vibport_8c1ba354Ptr, 0xbebacafe);

    //     $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);

    //     $this->shouldRead($init_8c03bd80Ptr, 0);
    //     $this->shouldRead($var_8c157a60Ptr, 0);
    //     $this->shouldRead($init_8c03bfa8Ptr, 0);

    //     $this->shouldCall('_gdFsReqDrvStat')->andReturn(0);
    //     $this->shouldWrite($init_8c03bfa8Ptr, 1);

    //     // GDD_DRVSTAT_OPEN
    //     $this->shouldCall('_gdFsGetDrvStat')->andReturn(0x06);

    //     $this->shouldRead($var_vibport_8c1ba354Ptr, 0xbebacafe);
    //     $this->shouldCall('_pdVibMxStop')->with(0xbebacafe);

    //     // FIXME: -1 & 0xffffffff
    //     $this->call('_njUserMain_8c01392e')->shouldReturn(-1 & 0xffffffff)->run();
    // }

    // public function test_njUserMain_8c01392e_0_0_0_idle_open()
    // {
    //     $init_8c03bd80Ptr = $this->allocRellocate('_init_8c03bd80', 4);
    //     $var_8c157a60Ptr = $this->allocRellocate('_var_8c157a60', 4);
    //     $init_8c03bfa8Ptr = $this->allocRellocate('_init_8c03bfa8', 4);
    //     $var_vibport_8c1ba354Ptr = $this->allocRellocate('_var_vibport_8c1ba354', 4);
    //     $this->initUint32($var_vibport_8c1ba354Ptr, 0xbebacafe);

    //     $var_tasks_8c1ba3c8Ptr = $this->allocRellocate('_var_tasks_8c1ba3c8', 4);

    //     $this->shouldRead($init_8c03bd80Ptr, 0);
    //     $this->shouldRead($var_8c157a60Ptr, 0);
    //     $this->shouldRead($init_8c03bfa8Ptr, 0);
        
    //     $this->shouldCall('_gdFsReqDrvStat')->andReturn(0);
    //     $this->shouldWrite($init_8c03bfa8Ptr, 1);

    //     // GDD_DRVSTAT_OPEN
    //     $this->shouldCall('_gdFsGetDrvStat')->andReturn(0x06);

    //     $this->shouldRead($var_vibport_8c1ba354Ptr, -1);

    //     // FIXME: -1 & 0xffffffff
    //     $this->call('_njUserMain_8c01392e')->shouldReturn(-1 & 0xffffffff)->run();
    // }

    private function allocRellocate($name, $size)
    {
        $ptr = $this->alloc($size);
        $this->rellocate($name, $ptr);
        return $ptr;
    }
};
