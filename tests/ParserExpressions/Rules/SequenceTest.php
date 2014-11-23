<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\String;

class SequenceTest extends PHPUnit_Framework_TestCase
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
    public function testCreateSequence($rules, $name)
    {
        $test = new Sequence($rules, $name);
        $fRule = $this->getAccessibleProperty(Sequence::class, 'rules');
        $fName = $this->getAccessibleProperty(Sequence::class, 'name');

        $this->assertSame($rules, $fRule->getValue($test));
        $this->assertSame($name, $fName->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(Sequence::class, 'rules');

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor'])
            ->disableOriginalConstructor()
            ->getMock();

        $context
            ->expects($this->exactly(2))
            ->method('getCursor')
            ->will($this->returnValue(1));
        $context
            ->expects($this->exactly(1))
            ->method('setCursor');

        $subrule = $this->getMockBuilder(String::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $subrule->expects($this->exactly(4))
            ->method('scan')
            ->will($this->onConsecutiveCalls(true, true, true, false));

        $rule->setValue($mock, [$subrule, $subrule]);

        $this->assertSame(true, $mock->scan($context));

        $rule->setValue($mock, [$subrule, $subrule, $subrule]);

        $this->assertSame(false, $mock->scan($context));
    }

    public function providerRule()
    {
        return [
            [['r', 'u', 'le', 's'], "Rule"],
            [['t', 'e', 's', 't'], "Test"],
            [['seq', 'ue', 'nce'], "Sequence"]
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
