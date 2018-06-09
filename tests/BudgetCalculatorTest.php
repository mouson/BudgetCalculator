<?php

require __DIR__ . '/../src/BudgetCalculator.php';

use PHPUnit\Framework\TestCase;

class BudgetCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_instaniate_class()
    {
        $actual = new BudgetCalculator();

        $this->assertInstanceOf(BudgetCalculator::class, $actual);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_end_bigger_than_start()
    {
        // Arrange
        $this->expectException(\Exception::class);

        // Act
        $start = '2018/02/03';
        $end =   '2018/02/01';

        $calculator = new BudgetCalculator();

        $actual = $calculator->calculate($start, $end);
    }

    /**
     * @test
     * @dataProvider datesProvider
     */
    public function getBudget($start, $end, $data, $expected)
    {
        // Arrange
        $model = Mockery::mock(new BudgetModel());
        $model->shouldReceive('query')->andReturn($data);

        $calculator = new BudgetCalculator($model);

        // Act
        $actual = $calculator->calculate($start, $end);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    public function datesProvider()
    {
        return [
            ['2018/03/01', '2018/03/31', $this->getData(), 0],
            ['2018/01/01', '2018/01/31', $this->getData(), 3100],
//            ['2017/07/18', '2018/02/16', $this->getData(), 0],
//            ['2018/01/01', '2018/01/31', 3100],
        ];
    }

    private function getData()
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