<?php

use GetSky\ParserExpressions\Rules\Any;
use GetSky\ParserExpressions\Runner;

require_once '../vendor/autoload.php';

class DateParser
{

    public function rule()
    {
        return Sequence(
            [
                ZeroOrMore("0"),
                $this->year(),
                $this->dot(),
                $this->month(),
                $this->dot(),
                $this->day(),
                PredicateAnd(new Any())
            ]
        );
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
        return CharRange(0, 9, 'Digital');
    }

    public function d19()
    {
        return CharRange(1, 9, 'Digital(1-9)');
    }

    public function d01()
    {
        return Optional(FirstOf([0, 1], 'Digital(0-1)'));
    }

    public function d03()
    {
        return Optional(CharRange(0, 3, 'Digital(0-1)'));
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
$runner = new Runner($parser->rule());

$array[] = $runner->run('0000000000000000002014-12-12a')->toArray();
$array[] = $runner->run('2014.01.04q')->toArray();
$array[] = $runner->run('201449d')->toArray();
print_r($array);