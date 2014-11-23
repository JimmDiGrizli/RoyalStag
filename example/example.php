<?php

use GetSky\ParserExpressions\Context;

require_once '../vendor/autoload.php';

class DateParser
{

    public function rule()
    {
        return Sequence([PredicateAnd(ZeroOrMore("0")),$this->year(), $this->dot(), $this->month(), $this->dot(), $this->day()]);
    }

    public function year()
    {
        return FirstOf(
            [
                [$this->digital(), $this->digital(), $this->digital(), $this->digital()],
                [$this->digital(), $this->digital()]
            ],
            'Year'
        );
    }

    public function digital()
    {
        return FirstOf([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], 'Digital');
    }

    public function d19()
    {
        return FirstOf([1, 2, 3, 4, 5, 6, 7, 8, 9], 'Digital(1-9)');
    }

    public function d01()
    {
        return Optional(FirstOf([0, 1], 'Digital(0-1)'));
    }

    public function d03()
    {
        return Optional(FirstOf([0, 1, 2, 3], 'Digital(0-1)'));
    }

    public function dot()
    {
        return Optional(FirstOf(['-', '.', '/']), 'Dot');
    }

    public function month()
    {
        return Sequence([$this->d01(), $this->d19()], 'Monthly');
    }

    public function day()
    {
        return Sequence([$this->d03(), $this->d19()], 'Day');
    }
}


$parser = new DateParser();
$context = new Context('0000000000000000002014-12-12');
print_r($parser->rule()->scan($context)->toArray());

$context = new Context('2014.01.04');
print_r($parser->rule()->scan($context)->toArray());

$context = new Context('20140409');
print_r($parser->rule()->scan($context)->toArray());

$context = new Context('201449');
print_r($parser->rule()->scan($context)->toArray());