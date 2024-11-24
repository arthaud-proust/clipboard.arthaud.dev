<?php

namespace App\Stats;

use App\Models\Stat;

class SizeTransferredStat
{
    private Stat $model;

    public function __construct()
    {
        $this->model = Stat::find('size_transferred');
    }

    public function value(): int
    {
        return $this->model->value;
    }

    public function add(int $sizeInKb)
    {
        $newValue = $this->model->value + $sizeInKb;

        $this->model->update([
            'value' => $newValue,
        ]);

        return $newValue;
    }
}
