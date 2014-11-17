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
    public function testCreateString($rule, $name)
    {
        $test = new String($rule, $name);
        $attribute = $this->getAccessibleProperty(String::class, 'rule');
        $fName = $this->getAccessibleProperty(String::class, 'name');

        $this->assertSame($rule, $attribute->getValue($test));
        $this->assertSame($name, $fName->getValue($test));
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

        $this->assertSame(true, $mock->scan($context));

        $rule->setValue($mock, 'Mi');

        $this->assertSame(false, $mock->scan($context));
    }

    public function providerRule()
    {
        return [
            ['test', 'Test'],
            ['put', 'Test2'],
            ['scan', 'Test3']
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
