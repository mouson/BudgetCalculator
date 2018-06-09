<?php

use Carbon\Carbon;

require __DIR__ . '/BudgetModel.php';

class BudgetCalculator
{
    /** @var BudgetModel $model */
    private $model;

    /**
     * BudgetCalculator constructor.
     */
    public function __construct($model = null)
    {
        $this->model = $model ?: new BudgetModel();
    }

    public function calculate($startDate, $endDate)
    {
        if ( ! $this->isValidDatePeriod($startDate, $endDate)) {
            throw new Exception('Invalid date');
        }

        $monthBudgets = $this->model->query();

        $start = new Carbon($startDate);
        $end = new Carbon($endDate);
        $iterator = $start->copy();

        $keys = [];
        while ($this->notDone($iterator, $end)) {
            $keys[] = $iterator->format('Ym');

            $iterator = $iterator->addMonth(1);
        }

        $sum = 0;


        if($start->format('Ym') == $end->format('Ym')) {
            $key = $start->format('Ym');

            if (isset($monthBudgets[$key])) {
                $days = $end->diffInDays($start) + 1;
                $ratio = $days / $start->daysInMonth;
                return $monthBudgets[$key] * $ratio;
            }
            return 0;
        }
        foreach ($keys as $i => $key) {
            $monthBudget = isset($monthBudgets[$key]) ? $monthBudgets[$key] : 0;

            if ($i == 0) {
                printf("%s:%d\n", 'first key', $key);
                $days = $start->copy()->lastOfMonth()->diffInDays($start) + 1;
                $ratio = $days / $start->daysInMonth;
                $sum += $monthBudget * $ratio;
            } elseif ($i == count($keys) - 1) {
                printf("%s:%d\n", 'last key', $key);
                $days = $end->day;
                $ratio = $days / $end->daysInMonth;
                $sum += $monthBudget * $ratio;
            } else {
                // do nothing
                $sum += $monthBudget;
            }


        }

        return $sum;
    }

    private function isValidDatePeriod($start, $end)
    {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);

        return $endDate >= $startDate;
    }

    private function notDone(Carbon $iterator, Carbon $end)
    {
        return $iterator->format('Ym') <= $end->format('Ym');
    }
}