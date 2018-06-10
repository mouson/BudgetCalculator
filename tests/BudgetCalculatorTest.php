<?php

namespace Tests\BudgetCalculatorTest;

use BudgetModel;
use Carbon\Carbon;
use \Mockery;
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
        $model = Mockery::mock(BudgetModel::class);
        /**
         * @var $model BudgetModel
         */
        $target = new BudgetCalculator($model);

        /** Assume */
        $this->expectException(\InvalidArgumentException::class);

        /** Act */
        $actual = $target->calculate(new Carbon('2018-05-05'), new Carbon('2018-01-01'));

    }

    /**
     * @test
     * @dataProvider CaseSets
     */
    public function testOneBudget($start, $end, $data, $expected)
    {
        $actual = $this->ShouldBeCalculate($start, $end, $data);

        /** Assert */
        $this->assertEquals($expected, $actual);
    }

    public function CaseSets()
    {
        return [
            ['2018-01-01', '2018-01-01', $this->Budget1Month(), 100],
            ['2018-01-01', '2018-01-31', $this->Budget1Month(), 3100],
            ['2018-01-01', '2018-02-28', $this->Budget3Month(), 5900],
            ['2018-01-01', '2018-03-31', $this->Budget3Month(), 5900],
            ['2018-03-03', '2018-03-13', $this->Budget3Month(), 0],
            ['2018-05-31', '2020-02-29', $this->BudgetOverYearMonth(), 3000],
        ];
    }

    private function BudgetOverYearMonth()
    {
        return [
            '201805' => 3100,
            '202002' => 2900,
            '202007' => 3100,
        ];
    }

    private function Budget3Month()
    {
        return [
            '201801' => 3100,
            '201802' => 2800,
            '201804' => 6000
        ];
    }

    private function Budget1Month()
    {
        return [
            '201801' => 3100,
        ];
    }

    /**
     * @param $start
     * @param $end
     * @param $data
     *
     * @return int
     */
    protected function ShouldBeCalculate($start, $end, $data): int
    {
        /** Arrange */
        $model = Mockery::mock(BudgetModel::class);
        $model->shouldReceive('query')->andReturn($data);

        /**
         * @var $model BudgetModel
         */
        $target = new BudgetCalculator($model);

        /** Act */
        $actual = $target->calculate(new Carbon($start), new Carbon($end));

        return $actual;
}
}
