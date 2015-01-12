<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rules\Any;

class AnyTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf(
            'GetSky\ParserExpressions\RuleInterface',
            $this->getObject()
        );
    }

    private function getObject()
    {
        return $this->getMockBuilder(Any::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testScan()
    {
        $mock = $this->getObject();

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor', 'error'])
            ->disableOriginalConstructor()
            ->getMock();

        $result = $this->getMockBuilder(Result::class)
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock();

        $result
            ->expects($this->never())
            ->method('getValue');

        $context
            ->expects($this->exactly(3))
            ->method('getCursor')
            ->will($this->returnValue(1));

        $context
            ->expects($this->never())
            ->method('setCursor');
        $context
            ->expects($this->exactly(3))
            ->method('value')
            ->will($this->onConsecutiveCalls(false, 'case', 'test'));

        $this->assertSame(false, $mock->scan($context));
        $this->assertInstanceOf(Result::class, $mock->scan($context));
        $this->assertInstanceOf(Result::class, $mock->scan($context));
    }

}
