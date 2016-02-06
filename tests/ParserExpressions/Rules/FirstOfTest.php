<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rules\FirstOf;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\Row;

class FirstOfTest extends PHPUnit_Framework_TestCase
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
    public function testCreateFirstOf($rules, $name, $resultRules)
    {
        $test = new FirstOf($rules, $name);
        $fRule = $this->getAccessibleProperty(FirstOf::class, 'rules');
        $fName = $this->getAccessibleProperty(FirstOf::class, 'name');

        $this->assertSame(count($resultRules), count($fRule->getValue($test)));
        $this->assertSame($name, $fName->getValue($test));
    }

    /**
     *
     */
    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(FirstOf::class, 'rules');

        $result = $this->getMockBuilder(Result::class)
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock();

        $result
            ->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue(1));

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor', 'error'])
            ->disableOriginalConstructor()
            ->getMock();

        $context
            ->expects($this->exactly(2))
            ->method('getCursor')
            ->will($this->returnValue(1));
        $context
            ->expects($this->exactly(5))
            ->method('setCursor');

        $subrule = $this->getMockBuilder(Row::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $subrule->expects($this->exactly(5))
            ->method('scan')
            ->will($this->onConsecutiveCalls(false, $result, false, false, false));

        $rule->setValue($mock, [$subrule, $subrule]);

        $this->assertInstanceOf(Result::class, $mock->scan($context));

        $rule->setValue($mock, [$subrule, $subrule, $subrule]);

        $this->assertSame(false, $mock->scan($context));
    }

    public function providerRule()
    {
        $string = $this->getMockBuilder(Row::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();
        $sequence = $this->getMockBuilder(Sequence::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();

        return [
            [
                [$string, $string, $string, $sequence],
                "Rules",
                [$string, $string, $string, $sequence]
            ],
            [
                [$string, $string, $sequence],
                "Test",
                [$string, $string, $sequence]
            ],
            [
                [$sequence, $string],
                "Rules",
                [$sequence, $string]
            ]
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
