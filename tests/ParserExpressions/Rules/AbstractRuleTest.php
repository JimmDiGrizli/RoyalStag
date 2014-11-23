<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rules\AbstractRule;
use GetSky\ParserExpressions\Rules\FirstOf;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\String;

class AbstractRuleTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf(
            'GetSky\ParserExpressions\Rule',
            $this->getObject()
        );

    }

    public function testGetName()
    {
        $rule = $this->getObject();
        $name = $this->getAccessibleProperty(AbstractRule::class, 'name');

        $name->setValue($rule, 'TestName');
        $this->assertSame('TestName', $rule->getName());

        $name->setValue($rule, 'Sequence');
        $this->assertSame('Sequence', $rule->getName());

    }

    public function testToRule()
    {
        $rule = $this->getObject();

        $string = $rule->toRule('String');
        $this->assertInstanceOf(String::class, $string);

        $sequence = $rule->toRule([$string, $string]);
        $this->assertInstanceOf(Sequence::class, $sequence);
    }

    /**
     * @return AbstractRule
     */
    private function getObject()
    {
        return $this->getMockBuilder(AbstractRule::class)
            ->getMockForAbstractClass();
    }

    private function getAccessibleProperty($class, $name)
    {
        $property = new ReflectionProperty($class, $name);
        $property->setAccessible(true);
        return $property;
    }
}
