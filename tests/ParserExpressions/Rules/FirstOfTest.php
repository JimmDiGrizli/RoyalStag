<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rules\FirstOf;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\String;

class FirstOfTest extends PHPUnit_Framework_TestCase
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
    public function testCreateFirstOf($rules)
    {
        $test = new FirstOf($rules);
        $rule = $this->getAccessibleProperty(FirstOf::class, 'rules');

        $this->assertSame($rules, $rule->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(FirstOf::class, 'rules');

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor'])
            ->disableOriginalConstructor()
            ->getMock();

        $context
            ->expects($this->exactly(2))
            ->method('getCursor')
            ->will($this->returnValue(1));
        $context
            ->expects($this->exactly(5))
            ->method('setCursor');

        $subrule = $this->getMockBuilder(String::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $subrule->expects($this->exactly(5))
            ->method('scan')
            ->will($this->onConsecutiveCalls(false, true, false, false, false));

        $rule->setValue($mock, [$subrule, $subrule]);

        $this->assertSame(true, $mock->scan($context));

        $rule->setValue($mock, [$subrule, $subrule, $subrule]);

        $this->assertSame(false, $mock->scan($context));
    }

    public function providerRule()
    {
        return [
            [['r', 'u', 'le', 's']],
            [['t', 'e', 's', 't']],
            [['seq', 'ue', 'nce']]
        ];
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getObject()
    {
        return $this->getMockBuilder(FirstOf::class)
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
