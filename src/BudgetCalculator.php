<?php

class BudgetCalculator
{

    /**
     * BudgetCalculator constructor.
     */
    public function __construct($startDate, $endDate)
    {
        if ( ! $this->isValidDatePeriod($startDate, $endDate)) {
            throw new Exception('Invalid date');
        }

        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function calculate()
    {


        return 0;
    }

    private function isValidDatePeriod($start, $end)
    {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);

        return $endDate >= $startDate;
    }
}