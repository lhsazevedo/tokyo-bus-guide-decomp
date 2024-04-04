<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;

return new class extends TestCase {
    public function test_itWorks()
    {
        // Resolve modlu symbol
        $this->setSize('__modlu', 4);

        $this->shouldCall('_FUN_8c012166')->andReturn(42);

        $this->call('_FUN_8c012178')
            ->with(20)
            ->shouldReturn(2)
            ->run();
    }

    public function test_itSkipsIfParamIsZero()
    {
        // Resolve modlu symbol
        $this->setSize('__modlu', 4);

        $this->call('_FUN_8c012178')
            ->with(0)
            ->shouldReturn(0)
            ->run();
    }
};
