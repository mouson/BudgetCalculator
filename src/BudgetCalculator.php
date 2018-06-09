<?php
namespace Mouson\BudgetCalculator;

use BudgetModel;
use Carbon\Carbon;

class BudgetCalculator
{
    /**
     * @var BudgetModel
     */
    private $model;

    public function __construct(BudgetModel $model)
    {

        $this->model = $model;
    }

    public function calculate(Carbon $start, Carbon $end)
    {
        if ($end->lt($start)) {
            throw new \InvalidArgumentException('Argument Invalid!!');
        }
        return 100;
    }
}
