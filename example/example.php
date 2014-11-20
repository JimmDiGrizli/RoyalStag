<?php

use GetSky\ParserExpressions\Context;

require_once '../vendor/autoload.php';

class DateParser
{

    public function rule()
    {
        return Sequence(
            [
                $this->year(),
                $this->dot(),
                $this->monthy(),
                $this->dot(),
                $this->day(),
            ]
        );
    }

    public function year()
    {
        return Sequence(
            [
                $this->digital(),
                $this->digital(),
                $this->digital(),
                $this->digital()
            ],
            'Year'
        );
    }

    public function monthy()
    {
        return Sequence(
            [
                $this->digital(),
                $this->digital()
            ],
            'Monthly'
        );
    }

    public function day()
    {
        return Sequence(
            [
                $this->digital(),
                $this->digital()
            ],
            'Day'
        );
    }

    public function digital()
    {
        return FirstOf(
            [
                String(0),
                String(1),
                String(2),
                String(3),
                String(4),
                String(5),
                String(6),
                String(7),
                String(8),
                String(9)
            ],
            'Digital'
        );
    }

    public function dot()
    {
        return Optional(
            FirstOf(
                [
                    String("."),
                    String("-"),
                    String("/")
                ]
            ),
            'Dot'
        );
    }
}


$parser = new DateParser();
$context = new Context('2014-12-12');
print_r($parser->rule()->scan($context)->toArray());

$context = new Context('2014.01.04');
print_r($parser->rule()->scan($context)->toArray());

$context = new Context('20140409');
print_r($parser->rule()->scan($context)->toArray());