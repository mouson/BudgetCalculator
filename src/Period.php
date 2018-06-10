<?php

namespace Mouson\BudgetCalculator;

use Carbon\Carbon;
use InvalidArgumentException;

class Period
{
    /**
     * @var Carbon
     */
    private $start;
    /**
     * @var Carbon
     */
    private $end;

    public function __construct(Carbon $start, Carbon $end)
    {

        $this->start = $start;
        $this->end   = $end;
    }

    public function isInvalidPeriod(): void
    {
        if ($this->end->lt($this->start)) {
            throw new InvalidArgumentException('Argument Invalid!!');
        }
    }

}
