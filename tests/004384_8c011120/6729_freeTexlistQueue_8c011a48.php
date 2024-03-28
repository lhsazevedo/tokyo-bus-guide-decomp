<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

return new class extends TestCase
{
    public function test_freeQueue(): void
    {
        $this->initUint32($this->addressOf('_var_texlistQueue_8c157aac'), 0xbebacafe);

        $this->shouldCall('_syFree')->with(0xbebacafe);

        $this->call('_freeTexlistQueue_8c011a48')->run();
    }

    public function test_doNotFreeUnallocatedQueue(): void
    {
        $this->initUint32($this->addressOf('_var_texlistQueue_8c157aac'), -1);

        $this->call('_freeTexlistQueue_8c011a48')->run();
    }
};
