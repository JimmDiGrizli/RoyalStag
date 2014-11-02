<?php
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
