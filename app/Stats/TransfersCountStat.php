<?php

namespace App\Stats;

use App\Models\Stat;

class TransfersCountStat
{
    private Stat $model;

    public function __construct()
    {
        $this->model = Stat::find('transfers_count');
    }

    public function value(): int
    {
        return $this->model->value;
    }

    public function increment()
    {
        $newValue = $this->model->value + 1;

        $this->model->update([
            'value' => $newValue,
        ]);

        return $newValue;
    }
}
