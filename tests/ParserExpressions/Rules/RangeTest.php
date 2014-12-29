<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rules\Range;
use GetSky\ParserExpressions\Rules\String;

class RangeTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf(
            'GetSky\ParserExpressions\Rules\AbstractRule',
            $this->getObject()
        );
    }

    /**
     * @dataProvider providerRule
     */
    public function testCreateString($left, $right, $name)
    {
        $test = new Range($left, $right, $name);
        $aLeft = $this->getAccessibleProperty(Range::class, 'left');
        $aRight = $this->getAccessibleProperty(Range::class, 'right');
        $aName = $this->getAccessibleProperty(Range::class, 'name');

        $this->assertSame((string)$left, $aLeft->getValue($test));
        $this->assertSame((string)$right, $aRight->getValue($test));
        $this->assertSame((string)$name, $aName->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $left = $this->getAccessibleProperty(Range::class, 'left');
        $right = $this->getAccessibleProperty(Range::class, 'right');

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor', 'error'])
            ->disableOriginalConstructor()
            ->getMock();

        $context
            ->expects($this->exactly(5))
            ->method('value')
            ->will($this->onConsecutiveCalls('1', '3', '8', 'a', 'П'));
        $context
            ->expects($this->exactly(5))
            ->method('getCursor')
            ->will($this->returnValue(1));
        $context
            ->expects($this->exactly(1))
            ->method('setCursor');

        $left->setValue($mock, '1');
        $right->setValue($mock, '5');
        $this->assertSame('1', $mock->scan($context)->getValue());

        $left->setValue($mock, '1');
        $right->setValue($mock, '3');
        $this->assertSame('3', $mock->scan($context)->getValue());

        $left->setValue($mock, '1');
        $right->setValue($mock, '7');
        $this->assertSame(false, $mock->scan($context));

        $left->setValue($mock, 'a');
        $right->setValue($mock, 'z');
        $this->assertSame('a', $mock->scan($context)->getValue());

        $left->setValue($mock, 'А');
        $right->setValue($mock, 'я');
        $this->assertSame('П', $mock->scan($context)->getValue());
    }

    public function providerRule()
    {
        return [
            [0, 9, 'Test'],
            [1, '8', 'Test2'],
            ['m', 's', 3]
        ];
    }

    private function getObject()
    {
        return $this->getMockBuilder(Range::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getAccessibleProperty($class, $name)
    {
        $property = new ReflectionProperty($class, $name);
        $property->setAccessible(true);
        return $property;
    }
}
