<?php

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Error;
use GetSky\ParserExpressions\Runner;

require_once '../../vendor/autoload.php';
require_once 'TimeParser.php';

$parser = new TimeParser();
$runner = new Runner(new Context(new Error()), $parser->hhmmss());

$broken = $runner->run('10:XX:10');

echo $runner->hasError();
