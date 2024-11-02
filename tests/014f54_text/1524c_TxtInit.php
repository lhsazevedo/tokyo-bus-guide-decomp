<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

return new class extends TestCase {
    public function test_test01()
    {
        $this->resolveSymbols();

        $var_8c1bc7a0 = $this->alloc(0x200 * 2);
        $this->shouldCall('_syMalloc')->with(0x200 * 2)->andReturn($var_8c1bc7a0);
        $this->shouldWriteLongTo('_var_8c1bc7a0', $var_8c1bc7a0);

        for ($i = 0; $i < 0x200; $i++) {
            $this->shouldWriteWord($var_8c1bc7a0 + $i * 2, -1);
        }

        $this->shouldCall('_syMalloc')->with(0x800)->andReturn(0xcafe0001);
        $this->shouldWriteLongTo('_var_glyphBuffer_8c1bc7a4', 0xcafe0001);

        $this->shouldCall('_syMalloc')->with(0x1800)->andReturn(0xcafe0002);
        $this->shouldWriteLongTo('_var_glyphTexnames_8c1bc78c', 0xcafe0002);

        $this->shouldCall('_syMalloc')->with(0x200 * 8)->andReturn(0xcafe0003);
        $this->shouldWriteLongTo('_var_glyphTexlists_8c1bc790', 0xcafe0003);

        $this->shouldWriteLong($this->addressOf('_var_fontResourceGroup_8c1bc794') + 4, $this->addressOf('_init_tanim_8c044128'));
        $this->shouldWriteLong($this->addressOf('_var_fontResourceGroup_8c1bc794') + 8, $this->addressOf('_init_contents_8c04413c'));
        //$this->shouldWriteLongTo('_var_8c1bc79c', $this->addressOf('_init_contents_8c04413c'));

        $this->call('_TxtInit_8c01524c')->run();
    }

    protected function resolveSymbols(): void
    {
    }

    protected function isAsmObject(): bool
    {
        return str_ends_with($this->objectFile, '_src.obj');
    }
};
