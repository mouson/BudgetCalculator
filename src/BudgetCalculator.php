<?php
namespace Mouson\BudgetCalculator;

use Carbon\Carbon;

class BudgetCalculator
{

    public function calculate(Carbon $start, Carbon $end)
    {
        if ($end->lt($start)) {
            throw new \InvalidArgumentException('Argument Invalid!!');
        }
        return 100;
    }
}
