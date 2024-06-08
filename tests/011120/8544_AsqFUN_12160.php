<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;

return new class extends TestCase {
    public function test_itSetsValue()
    {
        $this->initUint32($this->addressOf('_var_8c157acc'), 0);

        $this->shouldWriteTo('_var_8c157acc', 42);

        $this->call('_AsqFUN_12160')
            ->with(42)
            ->run();
    }
};
