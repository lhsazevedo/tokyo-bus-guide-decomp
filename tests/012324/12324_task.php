<?php

declare(strict_types=1);

use Lhsazevedo\Sh4ObjTest\TestCase;

return new class extends TestCase {
    public function test_basic_controller_0xf06fe()
    {
        $this->setSize('_var_peripheral_8c1ba35c', 0x34 * 2);
        $this->setSize('_var_8c157a70', 4);

        $per = $this->alloc(0x34);
        $info = $this->alloc(0x4);

        $this->initUint32($info, 1); // PDD_DEVTYPE_CONTROLLER
        $this->initUint32($per + 0x04, 0xf06fe);
        $this->initUint16($per + 0x1c, -64);
        $this->initUint32($per + 0x30, $info);

        $this->shouldWriteLongTo('_var_8c157a78', 0);
        $this->shouldCall('_pdGetPeripheral')
            ->with(0)
            ->andReturn($per);
        $this->shouldWriteLongTo('_var_peripheral_8c1ba358', $per);

        // TODO: Move implementation to Simulator
        $oddMvn = function () {
            $src = $this->registers[2];
            $dst = $this->registers[1];
            $len = $this->registers[0];

            for ($i = 0; $i < $len->value; $i++) {
                $this->memory->writeUInt8($dst->value + $i, $this->readUInt8($src->value + $i));
            }
        };

        $this->shouldCall('__quick_odd_mvn')->do($oddMvn);

        $this->shouldWriteLong

        $this->call('_task_8c012324')
            ->run();
    }
};