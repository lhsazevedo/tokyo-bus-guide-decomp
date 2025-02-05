<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

return new class extends TestCase {
    public function test_resetDatQueue_8c01116a()
    {
        $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), 0xbebacafe);

        $this->shouldWriteTo('_var_datQueueRear_8c157a90', 0xbebacafe);
        $this->shouldWriteStringTo('_var_queueBaseDir_8c157a80', 'DATA EMPTY');
        $this->shouldWriteTo('_var_datQueueIsIdle_8c157a98', 1);

        $this->singleCall('_resetDatQueue_8c01116a')
            ->run();
    }
};
