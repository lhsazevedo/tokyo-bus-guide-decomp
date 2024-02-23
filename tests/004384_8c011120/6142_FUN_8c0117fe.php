<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;

return new class extends TestCase {
    public function test_1()
    {
        $this->initUint32($this->addressOf('_var_uknQueue_8c157aac'), 0xbebacafe);
        $this->shouldWriteTo('_var_uknQueueCursor_8c157ab0', 0xbebacafe);
        $this->shouldWriteTo('_var_datQueueBaseDir_8c157a80', "DATA EMPTY");
        $this->shouldWriteTo('_var_8c157a68', 0);
        $this->shouldWriteTo('_var_8c157ab8', 1);

        $this->call('_FUN_8c0117fe')->run();
    }
};
