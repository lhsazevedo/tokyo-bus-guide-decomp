<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;

return new class extends TestCase {
    public function test_freeQueue()
    {
        $this->resolveImports();

        $this->initUint32($this->addressOf('_var_pvmQueue_8c157abc'), 0xbebacafe);

        $this->shouldCall('_syFree')->with(0xbebacafe);

        $this->call('_freePvmQueue_8c011e28')->run();
    }

    public function test_ignoresWhenUnitialized()
    {
        $this->resolveImports();

        $this->initUint32($this->addressOf('_var_pvmQueue_8c157abc'), -1);

        $this->call('_freePvmQueue_8c011e28')->run();
    }

    private function resolveImports()
    {
        // Functions
        $this->setSize('_syFree', 4);
    }
};
