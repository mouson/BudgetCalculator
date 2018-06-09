<?php
namespace Tests\BudgetCalculatorTest;

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
        $target = new BudgetCalculator();

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
        /** Arrange */
        $model = Mockery::mock(\BudgetModel::class);
        $model->shouldReceive('query')->andReturn($data);
        $target = new BudgetCalculator($model);

        /** Act */
        $actual = $target->calculate(new Carbon($start), new Carbon($end));

        /** Assert */
        $this->assertEquals($expected, $actual);
    }

    public function CaseSets()
    {
        return [
            ['2018-01-01', '2018-01-01', $this->BudgetSet(), 100],
        ];
    }

    private function BudgetSet()
    {
        return [
            '201801' => 3100,
            '201802' => 2800,
            '201804' => 6000,
            '201805' => 3100,
            '202002' => 2900,
            '202007' => 3100,
        ];
    }
}
