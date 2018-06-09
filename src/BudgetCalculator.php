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

        if ($start->isSameMonth($end, true)) {
            $budgets = $this->model->query();
            $budget = $budgets[$start->format('Ym')];

            $ratio = (($start->diffInDays($end)+1) / $start->daysInMonth);

            return $budget * $ratio;
        }
    }
}
