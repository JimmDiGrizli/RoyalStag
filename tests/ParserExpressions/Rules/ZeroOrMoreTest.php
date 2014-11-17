<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\String;
use GetSky\ParserExpressions\Rules\ZeroOrMore;

class ZeroOrMoreTest extends PHPUnit_Framework_TestCase
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
        $name = "ScanZeroOrMore";
        $test = new ZeroOrMore($rule, $name);
        $attribute = $this->getAccessibleProperty(ZeroOrMore::class, 'rule');
        $fName = $this->getAccessibleProperty(ZeroOrMore::class, 'name');

        $this->assertSame($rule, $attribute->getValue($test));
        $this->assertSame($name, $fName->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(ZeroOrMore::class, 'rule');

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor'])
            ->disableOriginalConstructor()
            ->getMock();

        $context
            ->expects($this->exactly(5))
            ->method('getCursor')
            ->will($this->returnValue(1));
        $context
            ->expects($this->exactly(2))
            ->method('setCursor');

        $subrule = $this->getMockBuilder(String::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $subrule->expects($this->exactly(5))
            ->method('scan')
            ->will($this->onConsecutiveCalls(true, true, true, false, false));

        $rule->setValue($mock, $subrule);

        $this->assertSame(true, $mock->scan($context));

        $this->assertSame(true, $mock->scan($context));
    }

    private function getObject()
    {
        return $this->getMockBuilder(ZeroOrMore::class)
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
