<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rules\Sequence;

class SequenceTest extends PHPUnit_Framework_TestCase
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
    public function testCreateContext($rules)
    {
        $test = new Sequence($rules);
        $rule = $this->getAccessibleProperty(Sequence::class, 'rules');

        $this->assertSame($rules, $rule->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(Sequence::class, 'rules');

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor'])
            ->disableOriginalConstructor()
            ->getMock();

        $string = $this->getAccessibleProperty(Context::class, 'string');

        $context
            ->expects($this->exactly(3))
            ->method('value')
            ->will($this->onConsecutiveCalls('My', 'Test'));
        $context
            ->expects($this->exactly(2))
            ->method('getCursor')
            ->will($this->returnValue(1));
        $context
            ->expects($this->exactly(1))
            ->method('setCursor');

        $rule->setValue($mock, ['My', 'Test']);
        $string->setValue($context, '1MyTest');

        $mock->scan($context);

        $rule->setValue($mock, ['Mi', 'Test']);

        $mock->scan($context);

    }

    public function providerRule()
    {
        return [
            [['r', 'u', 'le', 's']],
            [['t', 'e', 's', 't']],
            [['seq', 'ue', 'nce']]
        ];
    }

    private function getObject()
    {
        return $this->getMockBuilder(Sequence::class)
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
