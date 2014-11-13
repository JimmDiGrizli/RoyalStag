<?php

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rules\FirstOf;
use GetSky\ParserExpressions\Rules\OneOrMore;
use GetSky\ParserExpressions\Rules\Optional;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\String;
use GetSky\ParserExpressions\Rules\ZeroOrMore;

require_once '../vendor/autoload.php';

$context = new Context('1. We first parse!!');

$rule = new Sequence(
    [
        new Optional(new String("1. ")),
        new Optional(new String("2. ")),
        new Sequence(
            array(
                new ZeroOrMore(new String("!")),
                new FirstOf(
                    [new String('My'), new String('You'), new String('We')]
                ),
                new String(' ')
            )
        ),
        new Sequence(
            [
                new String('first'),
                new String(' ')
            ]
        ),
        new String('parse'),
        new OneOrMore(new String("!"))
    ]
);

var_dump($rule->scan($context));