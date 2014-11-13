<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rules\Optional;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\String;
use GetSky\ParserExpressions\Rules\ZeroOrMore;

class OptionalTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf(
            'GetSky\ParserExpressions\Rule',
            $this->getObject()
        );
    }

    public function testCreateZeroOrMore()
    {
        $rule = $this->getMockBuilder(String::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $test = new Optional($rule);
        $attribute = $this->getAccessibleProperty(Optional::class, 'rule');

        $this->assertSame($rule, $attribute->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(Optional::class, 'rule');

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor'])
            ->disableOriginalConstructor()
            ->getMock();

        $context
            ->expects($this->exactly(2))
            ->method('getCursor')
            ->will($this->returnValue(1));
        $context
            ->expects($this->exactly(1))
            ->method('setCursor');

        $subrule = $this->getMockBuilder(String::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $subrule->expects($this->exactly(2))
            ->method('scan')
            ->will($this->onConsecutiveCalls(true, false));

        $rule->setValue($mock, $subrule);

        $this->assertSame(true, $mock->scan($context));
        $this->assertSame(true, $mock->scan($context));
    }

    private function getObject()
    {
        return $this->getMockBuilder(Optional::class)
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
