<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rules\AnyOf;
use GetSky\ParserExpressions\Rules\Row;

class AnyOfTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf(
            'GetSky\ParserExpressions\Rules\AbstractRule',
            $this->getObject()
        );
    }

    public function testCreateString()
    {
        $rule = md5(rand(5000,80000));
        $name = md5(rand(5000,80000));
        $test = new AnyOf($rule, $name);
        $attribute = $this->getAccessibleProperty(AnyOf::class, 'rule');
        $fName = $this->getAccessibleProperty(AnyOf::class, 'name');

        $this->assertSame($rule, $attribute->getValue($test));
        $this->assertSame($name, $fName->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(AnyOf::class, 'rule');

        $result = $this->getMockBuilder(Result::class)
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock();

        $result
            ->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('e'));

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor', 'error'])
            ->disableOriginalConstructor()
            ->getMock();

        $context
            ->expects($this->exactly(2))
            ->method('value')
            ->will($this->onConsecutiveCalls('e', 'b'));
        $context
            ->expects($this->exactly(2))
            ->method('getCursor')
            ->will($this->returnValue(1));
        $context
            ->expects($this->exactly(1))
            ->method('setCursor');

        $rule->setValue($mock, 'test');

        $this->assertSame($result->getValue(), $mock->scan($context)->getValue());

        $rule->setValue($mock, 'tst');

        $this->assertSame(false, $mock->scan($context));
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getObject()
    {
        return $this->getMockBuilder(AnyOf::class)
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
