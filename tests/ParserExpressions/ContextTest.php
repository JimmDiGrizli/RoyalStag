<?php

use GetSky\ParserExpressions\Context;

class ContextText extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerText
     */
    public function testCreateContext($text)
    {
        $test = new Context($text);
        $string = $this->getAccessibleProperty(Context::class, 'string');

        $this->assertSame($text, $string->getValue($test));
    }

    /**
     * @dataProvider providerCursor
     */
    public function testSetGetCursor($cursor)
    {
        $mock = $this->getObject();
        $mock->setCursor($cursor);
        $this->assertSame($cursor, $mock->getCursor());
    }

    /**
     * @expectedException Exception
     */
    public function testExceptionSet()
    {
        $mock = $this->getObject();
        $mock->setCursor(-4);
    }

    /**
     * @dataProvider providerValue
     */
    public function testValue($text, $position, $size, $result, $nextPosition)
    {
        $mock = $this->getObject();
        $string = $this->getAccessibleProperty(Context::class, 'string');
        $string->setValue($mock, $text);
        $cursor = $this->getAccessibleProperty(Context::class, 'cursor');
        $cursor->setValue($mock, $position);

        $this->assertSame($result, $mock->value($size));
        $this->assertSame($nextPosition, $cursor->getValue($mock));
    }

    public function providerText()
    {
        return [['Test text'], ['Second test']];
    }

    public function providerCursor()
    {
        return [[4], [7], [0]];
    }

    public function providerValue()
    {
        return [
            ['Context', 3, 1, 't', 4],
            ['UnitTest', 4, 2, 'Te', 6],
            ['Center', 4, 4, false, 4]
        ];
    }

    private function getObject()
    {
        return $this->getMockBuilder(Context::class)
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
