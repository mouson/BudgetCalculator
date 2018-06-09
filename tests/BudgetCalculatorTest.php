<?php
namespace Tests\BudgetCalculatorTest;

use Carbon\Carbon;
use Mouson\BudgetCalculator\BudgetCalculator;
use PHPUnit\Framework\TestCase;

class BudgetCalculatorTest extends TestCase
{

    /**
     * @test
     */
    public function testDateInvalidate()
    {
        /** Arrange */
        $target = new BudgetCalculator();

        /** Assume */
        $this->expectException(\InvalidArgumentException::class);

        /** Act */
        $actual = $target->calculate(new Carbon('2018-05-05'), new Carbon('2018-01-01'));

    }
}
