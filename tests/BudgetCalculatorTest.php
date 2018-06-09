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
    public function getBudget($start, $end, $expected)
    {
        // Arrange
        $model = Mockery::mock();
        $calculator = new BudgetCalculator($model);

        // Act
        $actual = $calculator->calculate($start, $end);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    public function datesProvider()
    {
        return [
            ['2018/03/01', '2018/03/31', 0],
//            ['2018/01/01', '2018/01/31', 3100],
        ];
    }

}