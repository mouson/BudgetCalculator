<?php
require __DIR__ . '/BudgetModel.php';

class BudgetCalculator
{
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

//        $months = $this->getQueryMonths();

        return 0;
    }

    private function isValidDatePeriod($start, $end)
    {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);

        return $endDate >= $startDate;
    }

    private function getQueryMonths()
    {
        return [
            '201801'
        ];
    }
}