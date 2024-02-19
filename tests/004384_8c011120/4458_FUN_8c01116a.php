<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

return new class extends TestCase {
    public function test_FUN_8c01116a()
    {
        $this->initUint32($this->addressOf('_var_datQueue_8c157a8c'), 0xbebacafe);

        $this->shouldWriteTo('_var_datQueueRear_8c157a90', 0xbebacafe);
        $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', 'DATA EMPTY');
        $this->shouldWriteTo('_var_8c157a98', 1);

        $this->call('_FUN_8c01116a')
            ->run();
    }
};
