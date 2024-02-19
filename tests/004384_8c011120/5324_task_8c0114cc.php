<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;

function fdec(float $value) {
    return unpack('L', pack('f', $value))[1];
}

return new class extends TestCase {
    public function test_readsFirstItem()
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
        $this->initQueuedNj(
            address:  $currentQueuedNj,
            basedir:  $dirAStrAddress,
            filename: 0xcafe0002,
            dest:     $nj1Dest,
            dest2:    $nj1Dest2,
            flag:     0,
        );

        $currentQueuedNj += $sizeOfQueuedNj;
        $this->initQueuedNj(
            address:  $currentQueuedNj,
            basedir:  $dirBStrAddress,
            filename: 0xcafe1002,
            dest:     0xcafe1003,
            dest2:    0xcafe1004,
            flag:     0,
        );

        $currentQueuedNj += $sizeOfQueuedNj;
        $this->initQueuedNj(
            address:  $currentQueuedNj,
            basedir:  0xcafe2001,
            filename: 0xcafe2002,
            dest:     0xcafe2003,
            dest2:    0xcafe2004,
            flag:     0,
        );

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

    public function test_skipItemsWith0x10FlagSet()
    {
        $sizeOfQueuedNj = 0x14;
        $queueSize = 16;
        $njQueue = $this->alloc($queueSize * $sizeOfQueuedNj);

        $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
        $dirAStrAddress = $this->allocString('\\DIR_A');
        $dirBStrAddress = $this->allocString('\\DIR_B');

        $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

        /* Dat queue has 3 items */

        $currentQueuedNj = $njQueue;
        $nj1Dest = $this->alloc(4);
        $nj1Dest2 = $this->alloc(4);
        $this->initQueuedNj(
            address:  $currentQueuedNj,
            basedir:  $dirAStrAddress,
            filename: 0xcafe1002,
            dest:     $nj1Dest,
            dest2:    $nj1Dest2,
            flag:     1,
        );

        $currentQueuedNj += $sizeOfQueuedNj;
        $nj2Dest = $this->alloc(4);
        $nj2Dest2 = $this->alloc(4);
        $this->initQueuedNj(
            address:  $currentQueuedNj,
            basedir:  $dirBStrAddress,
            filename: 0xcafe2002,
            dest:     $nj2Dest,
            dest2:    $nj2Dest2,
            flag:     0,
        );

        $currentQueuedNj += $sizeOfQueuedNj;
        $this->initQueuedNj(
            address:  $currentQueuedNj,
            basedir:  0xcafe3001,
            filename: 0xcafe3002,
            dest:     0xcafe3003,
            dest2:    0xcafe3004,
            flag:     0,
        );

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

    public function test_gdFsOpenFailure()
    {
        $sizeOfQueuedNj = 0x14;
        $queueSize = 16;
        $njQueue = $this->alloc($queueSize * $sizeOfQueuedNj);

        $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
        $dirAStrAddress = $this->allocString('\\DIR_A');

        $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

        $this->initQueuedNj(
            address:  $njQueue,
            basedir:  $dirAStrAddress,
            filename: 0xcafe1002,
            dest:     0xcafe1003,
            dest2:    0xcafe1004,
            flag:     0,
        );

        $this->initUint32(
            $this->addressOf('_var_njQueueRear_8c157aa0'),
            $njQueue + 1 * $sizeOfQueuedNj
        );
        
        $taskPtr = $this->alloc(0x20);
        // task->field_0x08
        $this->initUint32($taskPtr + 0x08, 0);
        // task->queuedDat_0x18 points to the first item in the queue
        $this->initUint32($taskPtr + 0x18, $njQueue);
        
        $this->initUint32($this->addressOf('_var_8c157a84'), $this->addressOf('_var_texbuf_8c277ca0'));

        $sizeLocal = $this->isAsmObject() ? 0xffffd0 : 0xffffd0;

        // TODO: Implement blind shouldRead

        $strCmp = $this->isAsmObject() ? '_strcmp' : '__slow_strcmp1';
        $this->shouldCall($strCmp)
            ->with($dataEmptyStrAddress, $dirAStrAddress)
            ->andReturn(1);

        $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', $dirAStrAddress);
        $this->shouldCall('_gdFsChangeDir', $dirAStrAddress);

        // task->gdfs_0x0c = gdFsOpen(...)
        $this->shouldCall('_gdFsOpen')
            ->with(0xcafe1002, 0)
            ->andReturn(0);
        $this->shouldWrite($taskPtr + 0x0c, 0);

        $this->shouldWriteTo('_var_8c157a88', 1);
        $this->shouldWrite($taskPtr + 0x18, $njQueue + 1 * $sizeOfQueuedNj);
        $this->shouldWrite($taskPtr + 0x08, 0);

        $this->call('_task_8c0114cc')
            ->with($taskPtr, 0)
            ->run();
    }

    public function test_gdFsOpenFailureWithFree()
    {
        $sizeOfQueuedNj = 0x14;
        $queueSize = 16;
        $njQueue = $this->alloc($queueSize * $sizeOfQueuedNj);

        $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
        $dirAStrAddress = $this->allocString('\\DIR_A');

        $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

        $this->initQueuedNj(
            address:  $njQueue,
            basedir:  $dirAStrAddress,
            filename: 0xcafe1002,
            dest:     0xcafe1003,
            dest2:    0xcafe1004,
            flag:     0,
        );

        $this->initUint32(
            $this->addressOf('_var_njQueueRear_8c157aa0'),
            $njQueue + 1 * $sizeOfQueuedNj
        );
        
        $taskPtr = $this->alloc(0x20);
        // task->field_0x08
        $this->initUint32($taskPtr + 0x08, 0);
        // task->queuedDat_0x18 points to the first item in the queue
        $this->initUint32($taskPtr + 0x18, $njQueue);

        $readTarget = $this->alloc(4);
        $this->initUint32($this->addressOf('_var_8c157a84'), $readTarget);

        $sizeLocal = $this->isAsmObject() ? 0xffffd0 : 0xffffd0;

        // TODO: Implement blind shouldRead

        $strCmp = $this->isAsmObject() ? '_strcmp' : '__slow_strcmp1';
        $this->shouldCall($strCmp)
            ->with($dataEmptyStrAddress, $dirAStrAddress)
            ->andReturn(1);

        $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', $dirAStrAddress);
        $this->shouldCall('_gdFsChangeDir', $dirAStrAddress);

        // task->gdfs_0x0c = gdFsOpen(...)
        $this->shouldCall('_gdFsOpen')
            ->with(0xcafe1002, 0)
            ->andReturn(0);
        $this->shouldWrite($taskPtr + 0x0c, 0);

        $this->shouldCall('_syFree')->with($readTarget);

        $this->shouldWriteTo('_var_8c157a88', 1);
        $this->shouldWrite($taskPtr + 0x18, $njQueue + 1 * $sizeOfQueuedNj);
        $this->shouldWrite($taskPtr + 0x08, 0);

        $this->call('_task_8c0114cc')
            ->with($taskPtr, 0)
            ->run();
    }

    public function test_gdFsGetFileSctSizeFailure()
    {
        $sizeOfQueuedNj = 0x14;
        $queueSize = 16;
        $njQueue = $this->alloc($queueSize * $sizeOfQueuedNj);

        $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
        $dirAStrAddress = $this->allocString('\\DIR_A');

        $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

        $this->initQueuedNj(
            address:  $njQueue,
            basedir:  $dirAStrAddress,
            filename: 0xcafe1002,
            dest:     0xcafe1003,
            dest2:    0xcafe1004,
            flag:     0,
        );

        $this->initUint32(
            $this->addressOf('_var_njQueueRear_8c157aa0'),
            $njQueue + 1 * $sizeOfQueuedNj
        );
        
        $taskPtr = $this->alloc(0x20);
        // task->field_0x08
        $this->initUint32($taskPtr + 0x08, 0);
        // task->queuedDat_0x18 points to the first item in the queue
        $this->initUint32($taskPtr + 0x18, $njQueue);
        
        $this->initUint32($this->addressOf('_var_8c157a84'), $this->addressOf('_var_texbuf_8c277ca0'));

        $sizeLocal = $this->isAsmObject() ? 0xffffd0 : 0xffffd0;

        // TODO: Implement blind shouldRead

        $strCmp = $this->isAsmObject() ? '_strcmp' : '__slow_strcmp1';
        $this->shouldCall($strCmp)
            ->with($dataEmptyStrAddress, $dirAStrAddress)
            ->andReturn(1);

        $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', $dirAStrAddress);
        $this->shouldCall('_gdFsChangeDir', $dirAStrAddress);

        // task->gdfs_0x0c = gdFsOpen(...)
        $this->shouldCall('_gdFsOpen')
            ->with(0xcafe1002, 0)
            ->andReturn(0xf5f50000);
        $this->shouldWrite($taskPtr + 0x0c, 0xf5f50000);

        $this->shouldCall('_gdFsGetFileSctSize')
            ->with(0xf5f50000, $sizeLocal)
            ->do(function ($params) {
                $this->memory->writeUInt32($params[1], 0x100);
            })
            ->andReturn(0);

        $this->shouldWriteTo('_var_8c157a88', 1);
        $this->shouldWrite($taskPtr + 0x18, $njQueue + 1 * $sizeOfQueuedNj);
        $this->shouldWrite($taskPtr + 0x08, 0);

        $this->call('_task_8c0114cc')
            ->with($taskPtr, 0)
            ->run();
    }

    public function test_gdFsGetFileSctSizeFailureWithFree()
    {
        $sizeOfQueuedNj = 0x14;
        $queueSize = 16;
        $njQueue = $this->alloc($queueSize * $sizeOfQueuedNj);

        $dataEmptyStrAddress = $this->allocString('DATA EMPTY');
        $dirAStrAddress = $this->allocString('\\DIR_A');

        $this->initUint32($this->addressOf('_var_datQueueBaseDir_8c157a80'), $dataEmptyStrAddress);

        $this->initQueuedNj(
            address:  $njQueue,
            basedir:  $dirAStrAddress,
            filename: 0xcafe1002,
            dest:     0xcafe1003,
            dest2:    0xcafe1004,
            flag:     0,
        );

        $this->initUint32(
            $this->addressOf('_var_njQueueRear_8c157aa0'),
            $njQueue + 1 * $sizeOfQueuedNj
        );
        
        $taskPtr = $this->alloc(0x20);
        // task->field_0x08
        $this->initUint32($taskPtr + 0x08, 0);
        // task->queuedDat_0x18 points to the first item in the queue
        $this->initUint32($taskPtr + 0x18, $njQueue);

        $readTarget = $this->alloc(4);
        $this->initUint32($this->addressOf('_var_8c157a84'), $readTarget);

        $sizeLocal = $this->isAsmObject() ? 0xffffd0 : 0xffffd0;

        // TODO: Implement blind shouldRead

        $strCmp = $this->isAsmObject() ? '_strcmp' : '__slow_strcmp1';
        $this->shouldCall($strCmp)
            ->with($dataEmptyStrAddress, $dirAStrAddress)
            ->andReturn(1);

        $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', $dirAStrAddress);
        $this->shouldCall('_gdFsChangeDir', $dirAStrAddress);

        // task->gdfs_0x0c = gdFsOpen(...)
        $this->shouldCall('_gdFsOpen')
            ->with(0xcafe1002, 0)
            ->andReturn(0xf5f50000);
        $this->shouldWrite($taskPtr + 0x0c, 0xf5f50000);

        $this->shouldCall('_gdFsGetFileSctSize')
            ->with(0xf5f50000, $sizeLocal)
            ->do(function ($params) {
                $this->memory->writeUInt32($params[1], 0x100);
            })
            ->andReturn(0);

        $this->shouldCall('_syFree')->with($readTarget);

        $this->shouldWriteTo('_var_8c157a88', 1);
        $this->shouldWrite($taskPtr + 0x18, $njQueue + 1 * $sizeOfQueuedNj);
        $this->shouldWrite($taskPtr + 0x08, 0);

        $this->call('_task_8c0114cc')
            ->with($taskPtr, 0)
            ->run();
    }

    protected function isAsmObject(): bool
    {
        return str_ends_with($this->objectFile, '_src.obj');
    }

    protected function initQueuedNj(int $address, int $basedir, int $filename, int $dest, int $dest2, int $flag): void
    {
        $this->initUint32($address + 0x00, $basedir); // char* basedir;
        $this->initUint32($address + 0x04, $filename); // char* filename;
        $this->initUint32($address + 0x08, $dest); // void* dest;
        $this->initUint32($address + 0x0c, $dest2); // void* dest;
        $this->initUint32($address + 0x10, $flag); // int field_0x10;
    }
};
