<?php

class BudgetCalculator
{

    /**
     * BudgetCalculator constructor.
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}