<?php

require __DIR__ . '/../src/BudgetCalculator.php';

class BudgetCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
      * @test
      */
    public function it_should_instaniate_class()
    {
        $actual = new BudgetCalculator('2018/01/01', '2018/01/31');

        $this->assertInstanceOf(BudgetCalculator::class, $actual);
    }
}