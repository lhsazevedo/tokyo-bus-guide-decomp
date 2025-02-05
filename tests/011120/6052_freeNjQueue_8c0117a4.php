<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;

return new class extends TestCase {
    public function test_freeQueue()
    {
        $this->resolveImports();

        $this->initUint32($this->addressOf('_var_njQueue_8c157a9c'), 0xbebacafe);

        $this->shouldCall('_syFree')->with(0xbebacafe);

        $this->singleCall('_freeNjQueue_8c0117a4')->run();
    }

    public function test_ignoresWhenUnitialized()
    {
        $this->resolveImports();

        $this->initUint32($this->addressOf('_var_njQueue_8c157a9c'), -1);

        $this->singleCall('_freeNjQueue_8c0117a4')->run();
    }

    private function resolveImports()
    {
        // Functions
        $this->setSize('_syFree', 4);
    }
};
