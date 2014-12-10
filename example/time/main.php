<?

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Runner;

require_once '../../vendor/autoload.php';
require_once 'TimeParser.php';

$parser = new TimeParser();
$runner = new Runner(new Context(), $parser->time());

$array[] = $runner->run('10:12:10')->toArray();
$array[] = $runner->run('5:01:04')->toArray();
$array[] = $runner->run('5-08-14')->toArray();
$array[] = $runner->run('5_08')->toArray();
$array[] = $runner->run('221012')->toArray();
$array[] = $runner->run('1205')->toArray();
$array[] = $runner->run('11')->toArray();