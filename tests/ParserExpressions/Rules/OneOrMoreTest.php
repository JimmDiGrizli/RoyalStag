<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rules\OneOrMore;
use GetSky\ParserExpressions\Rules\String;

class OneOrMoreTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf(
            'GetSky\ParserExpressions\Rules\AbstractRule',
            $this->getObject()
        );
    }

    public function testCreateOneOrMore()
    {
        $rule = $this->getMockBuilder(String::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $name = "Scan";
        $test = new OneOrMore($rule, $name);
        $attribute = $this->getAccessibleProperty(OneOrMore::class, 'rule');
        $fName = $this->getAccessibleProperty(OneOrMore::class, 'name');

        $this->assertSame($rule, $attribute->getValue($test));
        $this->assertSame($name, $fName->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(OneOrMore::class, 'rule');

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor'])
            ->disableOriginalConstructor()
            ->getMock();

        $result = $this->getMockBuilder(Result::class)
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock();

        $result
            ->expects($this->exactly(3))
            ->method('getValue')
            ->will($this->returnValue(1));

        $context
            ->expects($this->exactly(5))
            ->method('getCursor')
            ->will($this->onConsecutiveCalls(1,2,3,4,1));
        $context
            ->expects($this->exactly(2))
            ->method('setCursor');

        $subrule = $this->getMockBuilder(String::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $subrule->expects($this->exactly(5))
            ->method('scan')
            ->will($this->onConsecutiveCalls($result, $result, $result, false,
                false));

        $rule->setValue($mock, $subrule);

        $this->assertInstanceOf(Result::class, $mock->scan($context));
        $this->assertSame(false, $mock->scan($context));
    }

    private function getObject()
    {
        return $this->getMockBuilder(OneOrMore::class)
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
