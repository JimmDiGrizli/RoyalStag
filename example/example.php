<?php

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\String;

require_once '../vendor/autoload.php';

$context = new Context('My first parse!');

$rule = new Sequence(
    [
        new Sequence(
            [
                new String('My'),
                new String(' ')
            ]
        ),
        new Sequence(
            [
                new String('first'),
                new String(' ')
            ]
        ),
        new String('parse'),
        new String('!')
    ]
);

var_dump($rule->scan($context));