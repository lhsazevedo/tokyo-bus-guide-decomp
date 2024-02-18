<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;

function fdec(float $value) {
    return unpack('L', pack('f', $value))[1];
}

return new class extends TestCase {
    // public function test_nop_8c011120()
    // {
    //     $this->call('_nop_8c011120')->run();
    // }

    // /// initDatQueue_8c011124 ///

    // public function test_initDatQueue_8c011124()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueItems = 16;

    //     $this->shouldCall('_syMalloc')
    //         ->with($queueItems * $sizeOfQueuedDat)
    //         ->andReturn(0xbebacafe);

    //     $this->shouldWriteTo('_var_datQueue_8c157a8c', 0xbebacafe);
    //     $this->shouldWriteTo('_var_datQueueTail_8c157a94', 0xbebacafe + $queueItems * $sizeOfQueuedDat);

    //     $this->call('_initDatQueue_8c011124')
    //         ->with($queueItems)
    //         ->shouldReturn(1)
    //         ->run();
    // }

    // public function test_initDatQueue_8c011124_returns0OnAllocError()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueItems = 16;

    //     $this->shouldCall('_syMalloc')
    //         ->with($queueItems * $sizeOfQueuedDat)
    //         ->andReturn(0);

    //     $this->shouldWriteTo('_var_datQueue_8c157a8c', 0);

    //     $this->call('_initDatQueue_8c011124')
    //         ->with($queueItems)
    //         ->shouldReturn(0)
    //         ->run();
    // }

    // public function test_initDatQueue_8c011124_clearQueueWhenNIs0()
    // {
    //     $this->shouldWriteTo('_var_datQueueTail_8c157a94', -1);
    //     $this->shouldWriteTo('_var_datQueue_8c157a8c', -1);

    //     $this->call('_initDatQueue_8c011124')
    //         ->with(0)
    //         ->shouldReturn(1)
    //         ->run();
    // }

    // /// FUN_8c01116a ///

    // public function test_FUN_8c01116a()
    // {
    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), 0xbebacafe);

    //     $this->shouldWriteTo('_var_datQueueRear_8c157a90', 0xbebacafe);
    //     $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', 'DATA EMPTY');
    //     $this->shouldWriteTo('_var_8c157a98', 1);

    //     $this->call('_FUN_8c01116a')
    //         ->run();
    // }

    // /// task_8c0111b4 ///

    // public function test_task_8c0111b4_case0_readsFirstItem()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);

    //     $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
    //     $dirStrAddress = $this->allocString('\\DIR');

    //     $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

    //     // Dat queue has 3 items
    //     $currentQueuedDat = $datQueue;
    //     $dat1Dest = $this->alloc(4);
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, $dat1Dest); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $currentQueuedDat += $sizeOfQueuedDat;
    //     $this->initUint32($currentQueuedDat + 0x00, 0xcafe0001); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, 0xcafe0003); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $currentQueuedDat += $sizeOfQueuedDat;
    //     $this->initUint32($currentQueuedDat + 0x00, 0xcafe0001); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, 0xcafe0003); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $this->initUint32(
    //         $this->addressOf('_var_datQueueRear_8c157a90'),
    //         $datQueue + 3 * $sizeOfQueuedDat
    //     );

    //     $taskPtr = $this->alloc(0x20);
    //     // task->field_0x08
    //     $this->initUint32($taskPtr + 0x08, 0);
    //     // task->queuedDat_0x18 points to the first item in the queue
    //     $this->initUint32($taskPtr + 0x18, $datQueue);

    //     $sizeLocal = $this->isAsmObject() ? 0xffffdc : 0xffffd4;

    //     /// First iteration

    //     // TODO: Implement blind shouldRead

    //     $strCmp = $this->isAsmObject() ? '_strcmp' : '__slow_strcmp1';
    //     $this->shouldCall($strCmp)
    //         ->with($dataEmptyStrAddress, $dirStrAddress)
    //         ->andReturn(1);

    //     $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', $dirStrAddress);
    //     $this->shouldCall('_gdFsChangeDir', $dirStrAddress);

    //     $this->shouldCall('_gdFsOpen')
    //         ->with(0xcafe0002, 0)
    //         ->andReturn(0xf5f50000);

    //     // task->gdfs_0x0c = gdFsOpen(...)
    //     $this->shouldWrite($taskPtr + 0x0c, 0xf5f50000);

    //     $this->shouldCall('_gdFsGetFileSctSize')
    //         ->with(0xf5f50000, $sizeLocal)
    //         ->do(function (...$params) use ($sizeLocal) {
    //             $this->writeUInt32($sizeLocal, 0, 5);
    //         })
    //         ->andReturn(1);

    //     // TODO: Use variable for qd_r14
    //     $this->shouldCall('_syMalloc')
    //         ->with(5 * 2048)
    //         ->andReturn(0xbebacafe);
    //     $this->shouldWrite($dat1Dest, 0xbebacafe);

    //     $this->shouldCall('_gdFsRead')
    //         ->with(0xf5f50000, 5, 0xbebacafe)
    //         ->andReturn(0); // GDD_ERR_OK

    //     $this->shouldCall('_gdFsClose')
    //         ->with(0xf5f50000);

    //     $this->shouldWrite($datQueue + 0x0c, 1);
    //     $this->shouldWrite($taskPtr + 0x18, $datQueue + $sizeOfQueuedDat);
    //     $this->shouldWrite($taskPtr + 0x08, 0);

    //     $this->call('_task_8c0111b4')
    //         ->with($taskPtr, 0)
    //         ->run();
    // }

    // public function test_task_8c0111b4_case0_skipsItemsWith0x0cFlagSet()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);

    //     $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
    //     $dirStrAddress = $this->allocString('\\DIR');

    //     $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

    //     // Dat queue has 3 items
    //     $currentQueuedDat = $datQueue;
    //     $dat1Dest = $this->alloc(4);

    //     // This will be skipped
    //     $this->initUint32($currentQueuedDat + 0x00, 0xcafe0001); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, 0xcafe0003); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 1); // int field_0x0c;

    //     // This will be read
    //     $currentQueuedDat += $sizeOfQueuedDat;
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, $dat1Dest); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $currentQueuedDat += $sizeOfQueuedDat;
    //     $this->initUint32($currentQueuedDat + 0x00, 0xcafe0001); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, 0xcafe0003); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $this->initUint32(
    //         $this->addressOf('_var_datQueueRear_8c157a90'),
    //         $datQueue + 3 * $sizeOfQueuedDat
    //     );

    //     $testQueuedDat = $datQueue + $sizeOfQueuedDat;

    //     $taskPtr = $this->alloc(0x20);
    //     // task->field_0x08
    //     $this->initUint32($taskPtr + 0x08, 0);
    //     // task->queuedDat_0x18 points to the first item in the queue
    //     $this->initUint32($taskPtr + 0x18, $datQueue);

    //     $sizeLocal = $this->isAsmObject() ? 0xffffdc : 0xffffd4;

    //     /// First iteration

    //     // TODO: Implement blind shouldRead

    //     $strCmp = $this->isAsmObject() ? '_strcmp' : '__slow_strcmp1';
    //     $this->shouldCall($strCmp)
    //         ->with($dataEmptyStrAddress, $dirStrAddress)
    //         ->andReturn(1);

    //     $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', $dirStrAddress);
    //     $this->shouldCall('_gdFsChangeDir', $dirStrAddress);

    //     $this->shouldCall('_gdFsOpen')
    //         ->with(0xcafe0002, 0)
    //         ->andReturn(0xf5f50000);

    //     // task->gdfs_0x0c = gdFsOpen(...)
    //     $this->shouldWrite($taskPtr + 0x0c, 0xf5f50000);

    //     $this->shouldCall('_gdFsGetFileSctSize')
    //         ->with(0xf5f50000, $sizeLocal)
    //         ->do(function (...$params) use ($sizeLocal) {
    //             $this->writeUInt32($sizeLocal, 0, 5);
    //         })
    //         ->andReturn(1);

    //     // TODO: Use variable for qd_r14
    //     $this->shouldCall('_syMalloc')
    //         ->with(5 * 2048)
    //         ->andReturn(0xbebacafe);
    //     $this->shouldWrite($dat1Dest, 0xbebacafe);

    //     $this->shouldCall('_gdFsRead')
    //         ->with(0xf5f50000, 5, 0xbebacafe)
    //         ->andReturn(0); // GDD_ERR_OK

    //     $this->shouldCall('_gdFsClose')
    //         ->with(0xf5f50000);

    //     $this->shouldWrite($testQueuedDat + 0x0c, 1);
    //     $this->shouldWrite($taskPtr + 0x18, $testQueuedDat + $sizeOfQueuedDat);
    //     $this->shouldWrite($taskPtr + 0x08, 0);

    //     $this->call('_task_8c0111b4')
    //         ->with($taskPtr, 0)
    //         ->run();
    // }

    // public function test_task_8c0111b4_case0_breaksOnQueueCursor()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);
    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);

    //     $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
    //     $dirStrAddress = $this->allocString('\\DIR');

    //     $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

    //     // Dat queue has 3 items
    //     $currentQueuedDat = $datQueue;
    //     $dat1Dest = $this->alloc(4);

    //     $this->initUint32($currentQueuedDat + 0x00, 0xcafe0001); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, 0xcafe0003); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 1); // int field_0x0c;

    //     $currentQueuedDat += $sizeOfQueuedDat;
    //     $this->initUint32($currentQueuedDat + 0x00, 0xcafe0001); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, 0xcafe0003); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 1); // int field_0x0c;

    //     $currentQueuedDat += $sizeOfQueuedDat;
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, $dat1Dest); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 1); // int field_0x0c;

    //     $this->initUint32(
    //         $this->addressOf('_var_datQueueRear_8c157a90'),
    //         $datQueue + 3 * $sizeOfQueuedDat
    //     );

    //     $taskPtr = $this->alloc(0x20);
    //     // task->field_0x08
    //     $this->initUint32($taskPtr + 0x08, 0);
    //     // task->queuedDat_0x18 points to the first item in the queue
    //     $this->initUint32($taskPtr + 0x18, $datQueue);

    //     $sizeLocal = $this->isAsmObject() ? 0xffffdc : 0xffffd4;

    //     $this->shouldReadFrom('_var_8c157a88', 1);
    //     $this->shouldWrite($taskPtr + 0x18, $datQueue);
    //     $this->shouldWriteTo('_var_8c157a88', 0);
    //     $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', 'DATA EMPTY');

    //     $this->call('_task_8c0111b4')
    //         ->with($taskPtr, 0)
    //         ->run();
    // }

    // public function test_task_8c0111b4_case0_breaksOnQueueCursorAndFreeTask()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);
    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);

    //     $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
    //     $dirStrAddress = $this->allocString('\\DIR');

    //     $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

    //     // Dat queue has 3 items
    //     $currentQueuedDat = $datQueue;
    //     $dat1Dest = $this->alloc(4);

    //     $this->initUint32($currentQueuedDat + 0x00, 0xcafe0001); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, 0xcafe0003); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 1); // int field_0x0c;

    //     $currentQueuedDat += $sizeOfQueuedDat;
    //     $this->initUint32($currentQueuedDat + 0x00, 0xcafe0001); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, 0xcafe0003); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 1); // int field_0x0c;

    //     $currentQueuedDat += $sizeOfQueuedDat;
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, $dat1Dest); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 1); // int field_0x0c;

    //     $this->initUint32(
    //         $this->addressOf('_var_datQueueRear_8c157a90'),
    //         $datQueue + 3 * $sizeOfQueuedDat
    //     );

    //     $taskPtr = $this->alloc(0x20);
    //     // task->field_0x08
    //     $this->initUint32($taskPtr + 0x08, 0);
    //     // task->queuedDat_0x18 points to the first item in the queue
    //     $this->initUint32($taskPtr + 0x18, $datQueue);

    //     $sizeLocal = $this->isAsmObject() ? 0xffffdc : 0xffffd4;

    //     $this->shouldReadFrom('_var_8c157a88', 0);
    //     $this->shouldWriteTo('_var_8c157a98', 1);
    //     $this->shouldCall('_freeTask_8c014b66')
    //         ->with($taskPtr);

    //     $this->call('_task_8c0111b4')
    //         ->with($taskPtr, 0)
    //         ->run();
    // }

    // public function test_task_8c0111b4_case1_gdfsStatComplete()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);
    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);

    //     $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
    //     $dirStrAddress = $this->allocString('\\DIR');

    //     $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

    //     $taskPtr = $this->alloc(0x20);
    //     // task->field_0x08
    //     $this->initUint32($taskPtr + 0x08, 1);
    //     // task->gdfs_0x0c
    //     $this->initUint32($taskPtr + 0x0c, 0xbebacafe);
    //     // task->queuedDat_0x18 points to the first item in the queue
    //     $this->initUint32($taskPtr + 0x18, $datQueue);

    //     $this->shouldCall('_gdFsGetStat')
    //         ->with(0xbebacafe)
    //         ->andReturn(1); // GDD_STAT_COMPLETE
    //     $this->shouldCall('_gdFsClose')
    //         ->with(0xbebacafe);
    //     $this->shouldWrite($datQueue + 0x0c, 1);
    //     $this->shouldWrite($taskPtr + 0x18, $datQueue + $sizeOfQueuedDat);
    //     $this->shouldWrite($taskPtr + 0x08, 0);

    //     $this->call('_task_8c0111b4')
    //         ->with($taskPtr, 0)
    //         ->run();
    // }

    // public function test_task_8c0111b4_case1_gdfsStatRead()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);
    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);

    //     $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
    //     $dirStrAddress = $this->allocString('\\DIR');

    //     $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

    //     $currentQueuedDat = $datQueue;
    //     $dat1Dest = $this->alloc(4);
    //     $this->initUint32($dat1Dest, 0xcafe1000);
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, $dat1Dest); // void** dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $taskPtr = $this->alloc(0x20);
    //     // task->field_0x08
    //     $this->initUint32($taskPtr + 0x08, 1);
    //     // task->gdfs_0x0c
    //     $this->initUint32($taskPtr + 0x0c, 0xbebacafe);
    //     // task->queuedDat_0x18 points to the first item in the queue
    //     $this->initUint32($taskPtr + 0x18, $datQueue);

    //     $this->shouldCall('_gdFsGetStat')
    //         ->with(0xbebacafe)
    //         ->andReturn(2); // GDD_STAT_READ
    //     $this->shouldCall('_gdFsGetTransStat')
    //         ->with(0xbebacafe)
    //         ->andReturn(0); // GDD_FS_TRANS_READY
    //     $this->shouldCall('_gdFsTrans32')
    //         ->with(0xbebacafe, 2048, 0xcafe1000);

    //     $this->call('_task_8c0111b4')
    //         ->with($taskPtr, 0)
    //         ->run();
    // }

    // public function test_task_8c0111b4_case1_gdfsStatRead_gdfsFsTransReady()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);
    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);

    //     $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
    //     $dirStrAddress = $this->allocString('\\DIR');

    //     $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

    //     $currentQueuedDat = $datQueue;
    //     $dat1Dest = $this->alloc(4);
    //     $this->initUint32($dat1Dest, 0xcafe1000);
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, $dat1Dest); // void** dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $taskPtr = $this->alloc(0x20);
    //     // task->field_0x08
    //     $this->initUint32($taskPtr + 0x08, 1);
    //     // task->gdfs_0x0c
    //     $this->initUint32($taskPtr + 0x0c, 0xbebacafe);
    //     // task->queuedDat_0x18 points to the first item in the queue
    //     $this->initUint32($taskPtr + 0x18, $datQueue);

    //     $this->shouldCall('_gdFsGetStat')
    //         ->with(0xbebacafe)
    //         ->andReturn(2); // GDD_STAT_READ
    //     $this->shouldCall('_gdFsGetTransStat')
    //         ->with(0xbebacafe)
    //         ->andReturn(0); // GDD_FS_TRANS_READY
    //     $this->shouldCall('_gdFsTrans32')
    //         ->with(0xbebacafe, 2048, 0xcafe1000);

    //     $this->call('_task_8c0111b4')
    //         ->with($taskPtr, 0)
    //         ->run();
    // }

    // public function test_task_8c0111b4_case1_gdfsStatRead_gdfsFsTransBusy()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);
    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);

    //     $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
    //     $dirStrAddress = $this->allocString('\\DIR');

    //     $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

    //     $currentQueuedDat = $datQueue;
    //     $dat1Dest = $this->alloc(4);
    //     $this->initUint32($dat1Dest, 0xcafe1000);
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, $dat1Dest); // void** dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $taskPtr = $this->alloc(0x20);
    //     // task->field_0x08
    //     $this->initUint32($taskPtr + 0x08, 1);
    //     // task->gdfs_0x0c
    //     $this->initUint32($taskPtr + 0x0c, 0xbebacafe);
    //     // task->queuedDat_0x18 points to the first item in the queue
    //     $this->initUint32($taskPtr + 0x18, $datQueue);

    //     $this->shouldCall('_gdFsGetStat')
    //         ->with(0xbebacafe)
    //         ->andReturn(2); // GDD_STAT_READ
    //     $this->shouldCall('_gdFsGetTransStat')
    //         ->with(0xbebacafe)
    //         ->andReturn(1); // GDD_FS_TRANS_BUSY

    //     $this->call('_task_8c0111b4')
    //         ->with($taskPtr, 0)
    //         ->run();
    // }

    // public function test_task_8c0111b4_case1_gdfsStatBusy()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);
    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);

    //     $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
    //     $dirStrAddress = $this->allocString('\\DIR');

    //     $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

    //     $currentQueuedDat = $datQueue;
    //     $dat1Dest = $this->alloc(4);
    //     $this->initUint32($dat1Dest, 0xcafe1000);
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, 0xcafe0002); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, $dat1Dest); // void** dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $taskPtr = $this->alloc(0x20);
    //     // task->field_0x08
    //     $this->initUint32($taskPtr + 0x08, 1);
    //     // task->gdfs_0x0c
    //     $this->initUint32($taskPtr + 0x0c, 0xbebacafe);
    //     // task->queuedDat_0x18 points to the first item in the queue
    //     $this->initUint32($taskPtr + 0x18, $datQueue);

    //     $this->shouldCall('_gdFsGetStat')
    //         ->with(0xbebacafe)
    //         ->andReturn(4); // GDD_STAT_BUSY
    //     $this->shouldCall('_gdFsClose')
    //         ->with(0xbebacafe);
    //     $this->shouldCall('_syFree', 0xcafe1000);

    //     $this->shouldWriteTo('_var_8c157a88', 1);
    //     $this->shouldWrite($taskPtr + 0x18, $datQueue + $sizeOfQueuedDat);
    //     $this->shouldWrite($taskPtr + 0x08, 0);

    //     $this->call('_task_8c0111b4')
    //         ->with($taskPtr, 0)
    //         ->run();
    // }

    // public function test_task_8c0111b4_nocase()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);
    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);

    //     $taskPtr = $this->alloc(0x20);
    //     // task->field_0x08
    //     $this->initUint32($taskPtr + 0x08, 2);

    //     $this->call('_task_8c0111b4')
    //         ->with($taskPtr, 0)
    //         ->run();
    // }

    /// task_8c0111b4 ///

    // public function test_sortDatQueueAndPushUnknownTask_8c011310()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);

    //     $dirStrAddress = $this->allocString('\\DIR');
    //     $fileAStrAddr = $this->allocString('FILEA.BIN');
    //     $fileBStrAddr = $this->allocString('FILEB.BIN');
    //     $fileCStrAddr = $this->allocString('FILEC.BIN');

    //     // Dat queue has 3 items
    //     $currentQueuedDat = $datQueue;
    //     $queuedDatA = $currentQueuedDat;
    //     $dat1Dest = $this->alloc(4);
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, $fileAStrAddr); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, $dat1Dest); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $currentQueuedDat += $sizeOfQueuedDat;
    //     $queuedDatB = $currentQueuedDat;
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, $fileCStrAddr); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, 0xcafe0003); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $currentQueuedDat += $sizeOfQueuedDat;
    //     $queuedDatC = $currentQueuedDat;
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, $fileBStrAddr); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, 0xcafe0003); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);
    //     $this->initUint32(
    //         $this->addressOf('_var_datQueueRear_8c157a90'),
    //         $datQueue + 3 * $sizeOfQueuedDat
    //     );

    //     //

    //     $this->shouldWriteTo('_var_8c157a98', 0);

    //     $tempQueuedDat = $this->alloc(4);
    //     $this->shouldCall('_syMalloc')
    //         ->with(3 * $sizeOfQueuedDat)
    //         ->andReturn($tempQueuedDat);

    //     // 1st iteration
    //     $strCmp = $this->isAsmObject() ? '_strcmp' : '__slow_strcmp1';
    //     $this->shouldCall($strCmp)
    //         ->with($fileAStrAddr, $fileCStrAddr)
    //         ->andReturn(strcmp('FILEA.BIN', 'FILEC.BIN'));

    //     $this->shouldCall($strCmp)
    //         ->with($fileCStrAddr, $fileBStrAddr)
    //         ->andReturn(strcmp('FILEC.BIN', 'FILEB.BIN'));


    //     // TODO: Move implementation to Simulator
    //     $evnMvn = function () {
    //         $src = $this->registers[2];
    //         $dst = $this->registers[1];
    //         $len = $this->registers[0];

    //         for ($i = 0; $i < $len; $i++) {
    //             $this->writeUInt8($dst + $i, 0, $this->readUInt8($src + $i));
    //         }
    //     };

    //     $this->shouldCall('__quick_evn_mvn')->do($evnMvn);
    //     $this->shouldCall('__quick_evn_mvn')->do($evnMvn);
    //     $this->shouldCall('__quick_evn_mvn')->do($evnMvn);

    //     $this->shouldCall($strCmp)
    //         ->with($fileAStrAddr, $fileBStrAddr)
    //         ->andReturn(strcmp('FILEA.BIN', 'FILEB.BIN'));

    //     $this->shouldCall($strCmp)
    //         ->with($fileBStrAddr, $fileCStrAddr)
    //         ->andReturn(strcmp('FILEB.BIN', 'FILEC.BIN'));

    //     $this->shouldCall('_syFree')
    //         ->with($tempQueuedDat);

    //     $createdTask = $this->alloc(0x1c);
    //     $this->initUint32(0xffffd4, $createdTask);
    //     $this->shouldCall('_pushTask_8c014ae8')
    //         ->with(
    //             $this->addressOf('_var_tasks_8c1ba3c8'),
    //             new WildcardArgument(), // TODO: Make addressOf handle exports
    //             0xffffd4,
    //             0xffffd8,
    //             0
    //         )
    //         ->andReturn(1);

    //     $this->shouldWrite($createdTask + 0x18, $datQueue);
    //     $this->shouldWrite($createdTask + 0x08, 0);
    //     $this->shouldWriteTo('_var_8c157a88', 0);
    //     $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', 'DATA EMPTY');

    //     $this->call('_sortDatQueueAndPushUnknownTask_8c011310')
    //         ->shouldReturn(1)
    //         ->run();
    // }

    // public function test_sortDatQueueAndPushUnknownTask_8c011310_returnsZeroOnEmptyQueue()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);

    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);
    //     $this->initUint32(
    //         $this->addressOf('_var_datQueueRear_8c157a90'),
    //         $datQueue,
    //     );

    //     $this->call('_sortDatQueueAndPushUnknownTask_8c011310')
    //         ->shouldReturn(0)
    //         ->run();
    // }

    // public function test_sortDatQueueAndPushUnknownTask_8c011310_returnsZeroOnPushFailure()
    // {
    //     $sizeOfQueuedDat = 0x10;
    //     $queueSize = 16;
    //     $datQueue = $this->alloc($queueSize * $sizeOfQueuedDat);

    //     $dirStrAddress = $this->allocString('\\DIR');
    //     $fileAStrAddr = $this->allocString('FILEA.BIN');

    //     $currentQueuedDat = $datQueue;
    //     $queuedDatA = $currentQueuedDat;
    //     $dat1Dest = $this->alloc(4);
    //     $this->initUint32($currentQueuedDat + 0x00, $dirStrAddress); // char* basedir;
    //     $this->initUint32($currentQueuedDat + 0x04, $fileAStrAddr); // char* filename;
    //     $this->initUint32($currentQueuedDat + 0x08, $dat1Dest); // void* dest;
    //     $this->initUint32($currentQueuedDat + 0x0c, 0); // int field_0x0c;

    //     $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), $datQueue);
    //     $this->initUint32(
    //         $this->addressOf('_var_datQueueRear_8c157a90'),
    //         $datQueue + 1 * $sizeOfQueuedDat
    //     );

    //     //

    //     $this->shouldWriteTo('_var_8c157a98', 0);

    //     $tempQueuedDat = $this->alloc(4);
    //     $this->shouldCall('_syMalloc')
    //         ->with(1 * $sizeOfQueuedDat)
    //         ->andReturn($tempQueuedDat);

    //     $this->shouldCall('_syFree')
    //         ->with($tempQueuedDat);

    //     $createdTask = $this->alloc(0x1c);
    //     $this->initUint32(0xffffd4, $createdTask);
    //     $this->shouldCall('_pushTask_8c014ae8')
    //         ->with(
    //             $this->addressOf('_var_tasks_8c1ba3c8'),
    //             new WildcardArgument(), // TODO: Make addressOf handle exports
    //             0xffffd4,
    //             0xffffd8,
    //             0
    //         )
    //         ->andReturn(0);

    //     $this->call('_sortDatQueueAndPushUnknownTask_8c011310')
    //         ->shouldReturn(0)
    //         ->run();
    // }

    /// task_8c0114cc ///

    public function test_task_8c0114cc_readsFirstItem()
    {
        $sizeOfQueuedNj = 0x14;
        $queueSize = 16;
        $njQueue = $this->alloc($queueSize * $sizeOfQueuedNj);

        $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
        $dirAStrAddress = $this->allocString('\\DIR_A');
        $dirBStrAddress = $this->allocString('\\DIR_B');

        $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

        // Dat queue has 3 items
        $currentQueuedNj = $njQueue;
        $nj1Dest = $this->alloc(4);
        $nj1Dest2 = $this->alloc(4);
        $this->initUint32($currentQueuedNj + 0x00, $dirAStrAddress); // char* basedir;
        $this->initUint32($currentQueuedNj + 0x04, 0xcafe0002); // char* filename;
        $this->initUint32($currentQueuedNj + 0x08, $nj1Dest); // void* dest;
        $this->initUint32($currentQueuedNj + 0x0c, $nj1Dest2); // void* dest;
        $this->initUint32($currentQueuedNj + 0x10, 0); // int field_0x10;

        $currentQueuedNj += $sizeOfQueuedNj;
        $this->initUint32($currentQueuedNj + 0x00, $dirBStrAddress); // char* basedir;
        $this->initUint32($currentQueuedNj + 0x04, 0xcafe1002); // char* filename;
        $this->initUint32($currentQueuedNj + 0x08, 0xcafe1003); // void* dest;
        $this->initUint32($currentQueuedNj + 0x0c, 0xcafe1004); // void* dest;
        $this->initUint32($currentQueuedNj + 0x10, 0); // int field_0x10;

        $currentQueuedNj += $sizeOfQueuedNj;
        $this->initUint32($currentQueuedNj + 0x00, 0xcafe2001); // char* basedir;
        $this->initUint32($currentQueuedNj + 0x04, 0xcafe2002); // char* filename;
        $this->initUint32($currentQueuedNj + 0x08, 0xcafe2003); // void* dest;
        $this->initUint32($currentQueuedNj + 0x0c, 0xcafe2004); // void* dest;
        $this->initUint32($currentQueuedNj + 0x10, 0); // int field_0x0c;

        $this->initUint32(
            $this->addressOf('_var_njQueueRear_8c157aa0'),
            $njQueue + 3 * $sizeOfQueuedNj
        );

        $taskPtr = $this->alloc(0x20);
        // task->field_0x08
        $this->initUint32($taskPtr + 0x08, 0);
        // task->queuedDat_0x18 points to the first item in the queue
        $this->initUint32($taskPtr + 0x18, $njQueue);

        $sizeLocal = $this->isAsmObject() ? 0xffffd0 : 0xffffd0;

        /// First iteration

        // TODO: Implement blind shouldRead

        $strCmp = $this->isAsmObject() ? '_strcmp' : '__slow_strcmp1';
        $this->shouldCall($strCmp)
            ->with($dataEmptyStrAddress, $dirAStrAddress)
            ->andReturn(1);

        $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', $dirAStrAddress);
        $this->shouldCall('_gdFsChangeDir', $dirAStrAddress);

        $this->shouldCall('_gdFsOpen')
            ->with(0xcafe0002, 0)
            ->andReturn(0xf5f50000);

        // task->gdfs_0x0c = gdFsOpen(...)
        $this->shouldWrite($taskPtr + 0x0c, 0xf5f50000);

        $this->shouldCall('_gdFsGetFileSctSize')
            ->with(0xf5f50000, $sizeLocal)
            ->do(function ($params) {
                $this->memory->writeUInt32($params[1], 0x100);
            })
            ->andReturn(1);

        $this->initUint32($this->addressOf('_var_texbuf_8c277ca0'), 0xbebacafe);
        $this->shouldWriteTo('_var_8c157a84', $this->addressOf('_var_texbuf_8c277ca0'));

        $this->shouldCall('_gdFsRead')
            ->with(0xf5f50000, 0x100, $this->addressOf('_var_texbuf_8c277ca0'))
            ->andReturn(0); // GDD_ERR_OK

        $this->shouldCall('_gdFsClose')->with(0xf5f50000);
        $this->shouldWrite($njQueue + 0x10, 1);

        $this->shouldCall('_njReadBinary')
            ->with(
                $this->addressOf('_var_texbuf_8c277ca0'),
                0xffffd4,
                0xffffd8,
            )
            ->andReturn(0xb1b1b1b1);
        $this->shouldWrite($nj1Dest, 0xb1b1b1b1);

        $this->shouldCall('_njReadBinary')
            ->with(
                $this->addressOf('_var_texbuf_8c277ca0'),
                0xffffd4,
                0xffffd8,
            )
            ->andReturn(0xb2b2b2b2);
        $this->shouldWrite($nj1Dest2, 0xb2b2b2b2);

        $this->shouldWrite($taskPtr + 0x18, $njQueue + $sizeOfQueuedNj);
        $this->shouldWrite($taskPtr + 0x08, 0);

        $this->call('_task_8c0114cc')
            ->with($taskPtr, 0)
            ->run();
    }

    public function test_task_8c0114cc_skipItemsWith0x10FlagSet()
    {
        $sizeOfQueuedNj = 0x14;
        $queueSize = 16;
        $njQueue = $this->alloc($queueSize * $sizeOfQueuedNj);

        $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
        $dirAStrAddress = $this->allocString('\\DIR_A');
        $dirBStrAddress = $this->allocString('\\DIR_B');

        $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

        /* Dat queue has 3 items */

        /* This will be skipped */
        $currentQueuedNj = $njQueue;
        $nj1Dest = $this->alloc(4);
        $nj1Dest2 = $this->alloc(4);
        $this->initUint32($currentQueuedNj + 0x00, $dirAStrAddress); // char* basedir;
        $this->initUint32($currentQueuedNj + 0x04, 0xcafe1002); // char* filename;
        $this->initUint32($currentQueuedNj + 0x08, $nj1Dest); // void* dest;
        $this->initUint32($currentQueuedNj + 0x0c, $nj1Dest2); // void* dest;
        $this->initUint32($currentQueuedNj + 0x10, 1); // int field_0x10;

        $currentQueuedNj += $sizeOfQueuedNj;
        $nj2Dest = $this->alloc(4);
        $nj2Dest2 = $this->alloc(4);
        $this->initUint32($currentQueuedNj + 0x00, $dirBStrAddress); // char* basedir;
        $this->initUint32($currentQueuedNj + 0x04, 0xcafe2002); // char* filename;
        $this->initUint32($currentQueuedNj + 0x08, $nj2Dest); // void* dest;
        $this->initUint32($currentQueuedNj + 0x0c, $nj2Dest2); // void* dest;
        $this->initUint32($currentQueuedNj + 0x10, 0); // int field_0x10;

        $currentQueuedNj += $sizeOfQueuedNj;
        $this->initUint32($currentQueuedNj + 0x00, 0xcafe3001); // char* basedir;
        $this->initUint32($currentQueuedNj + 0x04, 0xcafe3002); // char* filename;
        $this->initUint32($currentQueuedNj + 0x08, 0xcafe3003); // void* dest;
        $this->initUint32($currentQueuedNj + 0x0c, 0xcafe3004); // void* dest;
        $this->initUint32($currentQueuedNj + 0x10, 0); // int field_0x10;

        $this->initUint32(
            $this->addressOf('_var_njQueueRear_8c157aa0'),
            $njQueue + 3 * $sizeOfQueuedNj
        );

        $taskPtr = $this->alloc(0x20);
        // task->field_0x08
        $this->initUint32($taskPtr + 0x08, 0);
        // task->queuedDat_0x18 points to the first item in the queue
        $this->initUint32($taskPtr + 0x18, $njQueue);

        $sizeLocal = $this->isAsmObject() ? 0xffffd0 : 0xffffd0;

        // TODO: Implement blind shouldRead

        $strCmp = $this->isAsmObject() ? '_strcmp' : '__slow_strcmp1';
        $this->shouldCall($strCmp)
            ->with($dataEmptyStrAddress, $dirBStrAddress)
            ->andReturn(1);

        $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', $dirBStrAddress);
        $this->shouldCall('_gdFsChangeDir', $dirBStrAddress);

        $this->shouldCall('_gdFsOpen')
            ->with(0xcafe2002, 0)
            ->andReturn(0xf5f50000);

        // task->gdfs_0x0c = gdFsOpen(...)
        $this->shouldWrite($taskPtr + 0x0c, 0xf5f50000);

        $this->shouldCall('_gdFsGetFileSctSize')
            ->with(0xf5f50000, $sizeLocal)
            ->do(function ($params) {
                $this->memory->writeUInt32($params[1], 0x100);
            })
            ->andReturn(1);

        $this->initUint32($this->addressOf('_var_texbuf_8c277ca0'), 0xbebacafe);
        $this->shouldWriteTo('_var_8c157a84', $this->addressOf('_var_texbuf_8c277ca0'));

        $this->shouldCall('_gdFsRead')
            ->with(0xf5f50000, 0x100, $this->addressOf('_var_texbuf_8c277ca0'))
            ->andReturn(0); // GDD_ERR_OK

        $this->shouldCall('_gdFsClose')->with(0xf5f50000);
        $this->shouldWrite($njQueue + 1 * $sizeOfQueuedNj + 0x10, 1);

        $this->shouldCall('_njReadBinary')
            ->with(
                $this->addressOf('_var_texbuf_8c277ca0'),
                0xffffd4,
                0xffffd8,
            )
            ->andReturn(0xb1b1b1b1);
        $this->shouldWrite($nj2Dest, 0xb1b1b1b1);

        $this->shouldCall('_njReadBinary')
            ->with(
                $this->addressOf('_var_texbuf_8c277ca0'),
                0xffffd4,
                0xffffd8,
            )
            ->andReturn(0xb2b2b2b2);
        $this->shouldWrite($nj2Dest2, 0xb2b2b2b2);

        $this->shouldWrite($taskPtr + 0x18, $njQueue + 2 * $sizeOfQueuedNj);
        $this->shouldWrite($taskPtr + 0x08, 0);

        $this->call('_task_8c0114cc')
            ->with($taskPtr, 0)
            ->run();
    }

    protected function allocString(string $str): int
    {
        $address = $this->alloc(strlen($str) + 1);
        foreach (str_split($str) as $i => $char) {
            $this->initUint8($address + $i, ord($char));
        }
        $this->initUint8($address + strlen($str), 0);
        return $address;
    }

    protected function isAsmObject(): bool
    {
        return str_ends_with($this->objectFile, '_src.obj');
    }
};
