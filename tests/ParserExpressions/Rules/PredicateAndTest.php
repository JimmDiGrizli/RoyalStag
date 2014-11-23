<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rule;
use GetSky\ParserExpressions\Rules\PredicateAnd;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\String;
use GetSky\ParserExpressions\Rules\ZeroOrMore;

class PredicateAndTest extends PHPUnit_Framework_TestCase
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
        $rule = $this->getMockBuilder(String::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $name = "PredicateAnd";
        $test = new PredicateAnd($rule, $name);
        $attribute = $this->getAccessibleProperty(PredicateAnd::class, 'rule');
        $fName = $this->getAccessibleProperty(PredicateAnd::class, 'name');

        $this->assertSame($rule, $attribute->getValue($test));
        $this->assertSame($name, $fName->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(PredicateAnd::class, 'rule');

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
            ->expects($this->exactly(1))
            ->method('setCursor');

        $subrule = $this->getMockBuilder(Rule::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $subrule->expects($this->exactly(3))
            ->method('scan')
            ->will($this->onConsecutiveCalls($result, true, false));

        $rule->setValue($mock, $subrule);
        $this->assertSame(true, $mock->scan($context));
        $this->assertSame(true, $mock->scan($context));
        $this->assertSame(false, $mock->scan($context));
    }



    private function getObject()
    {
        return $this->getMockBuilder(PredicateAnd::class)
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
