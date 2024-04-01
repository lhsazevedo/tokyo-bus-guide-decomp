<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;
use Lhsazevedo\Sh4ObjTest\Simulator\Arguments\WildcardArgument;

return new class extends TestCase {
    public function test_itUpdatesAndReturnsValue()
    {
        $this->initUint32($this->addressOf('_var_8c157ad0'), 42);

        $this->shouldWriteTo('_var_8c157ad0', 158);

        $this->call('_FUN_8c0121a8')
            ->shouldReturn(158)
            ->run();
    }
};
