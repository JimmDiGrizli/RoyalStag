<?php
use GetSky\ParserExpressions\Rules\FirstOf;
use GetSky\ParserExpressions\Rules\Row;

class ActionParser
{
    public $action = null;

    public function closure()
    {
        return new FirstOf([$this->foo(), $this->bar()]);
    }

    public function foo()
    {
        return new Row(
            'foo',
            'Row',
            function () {
                $this->action = 'It\'s foo-action!';
            }
        );
    }

    public function bar()
    {
        return new Row(
            'bar',
            'Row',
            function () {
                $this->action = 'It\'s bar-action!';
            }
        );
    }
}
