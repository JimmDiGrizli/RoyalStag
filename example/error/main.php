<?php

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Error;
use GetSky\ParserExpressions\Runner;

require_once '../../vendor/autoload.php';
require_once '../time/TimeParser.php';

$parser = new TimeParser();
$runner = new Runner($parser->time());

$broken = $runner->run('10XX10');

$error = $runner->hasError();
