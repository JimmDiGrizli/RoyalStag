<?php

use GetSky\ParserExpressions\Context;

require_once '../vendor/autoload.php';

$context = new Context('1. We first parse!!');


$rule = Sequence(
    [
        Optional(String("1. ")),
        Optional(String("2. ")),
        Sequence(
            [
                ZeroOrMore(String("!")),
                FirstOf(
                    [String('My'), String('You'), String('We')]
                ),
                String(' ')
            ]
        ),
        Sequence(
            [
                String('first'),
                String(' ')
            ]
        ),
        String('parse'),
        OneOrMore(String("!"))
    ]
);

print_r($rule->scan($context));