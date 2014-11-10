<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\String;

class StringTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf(
            'GetSky\ParserExpressions\Rule',
            $this->getObject()
        );
    }

    /**
     * @dataProvider providerRule
     */
    public function testCreateString($rule)
    {
        $test = new String($rule);
        $attribute = $this->getAccessibleProperty(String::class, 'rule');

        $this->assertSame($rule, $attribute->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(String::class, 'rule');

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor'])
            ->disableOriginalConstructor()
            ->getMock();

        $context
            ->expects($this->exactly(2))
            ->method('value')
            ->will($this->onConsecutiveCalls('My', 'Test'));
        $context
            ->expects($this->exactly(2))
            ->method('getCursor')
            ->will($this->returnValue(1));
        $context
            ->expects($this->exactly(1))
            ->method('setCursor');

        $rule->setValue($mock, 'My');

        $mock->scan($context);

        $rule->setValue($mock, 'Mi');

        $mock->scan($context);
    }

    public function providerRule()
    {
        return [
            ['test'],
            ['put'],
            ['scan']
        ];
    }

    private function getObject()
    {
        return $this->getMockBuilder(String::class)
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
