<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rules\Any;
use GetSky\ParserExpressions\Rules\EOI;

class EOITest extends PHPUnit_Framework_TestCase
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
        return $this->getMockBuilder(EOI::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testScan()
    {
        $mock = $this->getObject();

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor'])
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
            ->expects($this->exactly(2))
            ->method('setCursor');

        $context
            ->expects($this->exactly(3))
            ->method('value')
            ->will($this->onConsecutiveCalls(false, 'case', 'test'));

        $this->assertSame(true, $mock->scan($context));
        $this->assertSame(false, $mock->scan($context));
        $this->assertSame(false, $mock->scan($context));
    }
}
