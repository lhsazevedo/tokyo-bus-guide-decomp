<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

return new class extends TestCase {
    public function test_AsqNop_11120()
    {
        $this->singleCall('_AsqNop_11120')->run();
    }
};
