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
        $iterator = $start;

        $keys = [];
        while ($this->notDone($iterator, $end)) {
            $keys[] = $iterator->format('Ym');

            $iterator = $iterator->addMonth(1);
        }

        $sum = 0;
        foreach ($keys as $i => $key) {
            if ($i == 0) {
                printf("%s:%d\n", 'first key', $key);
                echo $start->copy()->lastOfMonth()->diffInDays($start) . PHP_EOL;
            } elseif ($i == count($keys) - 1) {
                printf("%s:%d\n", 'last key', $key);
                echo $end->day . PHP_EOL;
            } else {
                // do nothing
            }

            if (isset($monthBudgets[$key])) {
                $sum += $monthBudgets[$key];
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