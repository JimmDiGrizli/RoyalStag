<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rules\Row;

class RowTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf(
            'GetSky\ParserExpressions\Rules\AbstractRule',
            $this->getObject()
        );
    }

    /**
     * @dataProvider providerRule
     */
    public function testCreateString($rule, $name, $action)
    {
        $test = new Row($rule, $name);
        $attribute = $this->getAccessibleProperty(Row::class, 'rule');
        $fName = $this->getAccessibleProperty(Row::class, 'name');

        $this->assertSame($rule, $attribute->getValue($test));
        $this->assertSame($name, $fName->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(Row::class, 'rule');
        $action = $this->getAccessibleProperty(Row::class, 'action');
        $action->setValue($mock, function () {
                return true;
            });
        $result = $this->getMockBuilder(Result::class)
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock();

        $result
            ->expects($this->once())


            ->method('getValue')
            ->will($this->returnValue('My'));

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor', 'error'])
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

        $this->assertSame($result->getValue(),
            $mock->scan($context)->getValue());

        $rule->setValue($mock, 'Mi');

        $this->assertSame(false, $mock->scan($context));
    }

    public function providerRule()
    {
        return [
            ['test', 'Test', null],
            ['put', 'Test2', null],
            [
                'scan',
                'Test3',
                function () {
                    return true;
                }
            ]
        ];
    }

    private function getObject()
    {
        return $this->getMockBuilder(Row::class)
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
