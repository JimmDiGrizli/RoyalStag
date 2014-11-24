<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rule;
use GetSky\ParserExpressions\Rules\PredicateNot;

class PredicateNotTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf(
            'GetSky\ParserExpressions\Rules\AbstractRule',
            $this->getObject()
        );
    }

    public function testCreatePredicateAnd()
    {
        $rule = $this->getMockBuilder(Rule::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $name = "PredicateNot";
        $test = new PredicateNot($rule, $name);
        $attribute = $this->getAccessibleProperty(PredicateNot::class, 'rule');
        $fName = $this->getAccessibleProperty(PredicateNot::class, 'name');

        $this->assertSame($rule, $attribute->getValue($test));
        $this->assertSame($name, $fName->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(PredicateNot::class, 'rule');

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor'])
            ->disableOriginalConstructor()
            ->getMock();

        $result = $this->getMockBuilder(Result::class)
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock();

        $context
            ->expects($this->exactly(3))
            ->method('getCursor')
            ->will($this->onConsecutiveCalls(1));
        $context
            ->expects($this->exactly(3))
            ->method('setCursor');

        $subrule = $this->getMockBuilder(Rule::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $subrule->expects($this->exactly(3))
            ->method('scan')
            ->will($this->onConsecutiveCalls($result, true, false));

        $rule->setValue($mock, $subrule);
        $this->assertSame(false, $mock->scan($context));
        $this->assertSame(false, $mock->scan($context));
        $this->assertSame(true, $mock->scan($context));
    }



    private function getObject()
    {
        return $this->getMockBuilder(PredicateNot::class)
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
