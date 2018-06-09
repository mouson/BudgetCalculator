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

        $budgets = $this->model->query();
        if ($start->isSameMonth($end, true)) {

            $budget = $this->getBudget($budgets, $start->format('Ym'));;

            $ratio = (($start->diffInDays($end)+1) / $start->daysInMonth);

            return $budget * $ratio;
        }

        $total_budget = 0;
        for (
            $date = $start->copy();
            ! $date->isSameMonth($end->copy()->addMonthNoOverflow(), true);
            $date->addMonthNoOverflow()
        ) {
            $budget = $this->getBudget($budgets, $date->format('Ym'));

            if ($date->isSameMonth($start)) {
                $days = ($start->daysInMonth - $start->day) +1;

                $ratio = ($days / $start->daysInMonth);
            } else if ($date->isSameMonth($end)) {
                $days = $end->day;
                $ratio = ($days / $end->daysInMonth);
            } else {
                $ratio = 1;
            }

            $total_budget += $budget * $ratio;

        }

        return $total_budget;
    }

    /**
     * @param $budgets
     * @param $date_string
     *
     * @return mixed
     */
    protected function getBudget($budgets, $date_string)
    {
        if (isset($budgets[$date_string])) {
            return $budgets[$date_string];
        }

        return 0;
}
}
