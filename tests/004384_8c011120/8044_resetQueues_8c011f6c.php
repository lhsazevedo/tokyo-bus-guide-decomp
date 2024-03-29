<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;

return new class extends TestCase {
    public function test_resetQueue()
    {
        $this->initUint32($this->addressOf('_var_pvmQueue_8c157abc'), 0xbebacafe);

        $this->shouldCall('_resetDatQueue_8c01116a')->with();
        $this->shouldCall('_resetNjQueue_8c01147a')->with();
        $this->shouldCall('_resetTexlistQueue_8c0117fe')->with();

        $this->shouldWriteTo('_var_pvmQueueRear_8c157ac0', 0xbebacafe);
        $this->shouldWriteTo('_var_queueBaseDir_8c157a80', 'DATA EMPTY');
        $this->shouldWriteTo('_var_pvmQueueIsIdle_8c157ac8', 1);

        $this->call('_resetQueues_8c011f6c')->run();
    }
};
