RoyalStag
=========
[![Build Status](https://travis-ci.org/JimmDiGrizli/RoyalStag.svg)](https://travis-ci.org/JimmDiGrizli/RoyalStag)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JimmDiGrizli/RoyalStag/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/JimmDiGrizli/RoyalStag/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/g/JimmDiGrizli/RoyalStag/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/JimmDiGrizli/RoyalStag/?branch=develop)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d2b5f130-4e85-46fb-873f-bfcc9583c745/mini.png)](https://insight.sensiolabs.com/projects/d2b5f130-4e85-46fb-873f-bfcc9583c745)

RoyalStag is a PHP library providing for easy-to-use, yet powerful parsing of
arbitrary input text based on parsing expression grammars.

In computer science, a parsing expression grammar, 
or [PEG](http://en.wikipedia.org/wiki/Parsing_expression_grammar "Parsing expression grammar"), 
is a type of analytic formal grammar, i.e. it describes a formal language in 
terms of a set of rules for recognizing strings in the language. The formalism 
was introduced by Bryan Ford in 2004 and is closely related to the family of 
top-down parsing languages introduced in the early 1970s. Syntactically, PEGs 
also look similar to context-free grammars (CFGs), but they have a different 
interpretation: the choice operator selects the first match in PEG, while it is 
ambiguous in CFG. This is closer to how string recognition tends to be done in 
practice, e.g. by a recursive descent parser.

Simple example
--------------
The following example shows operating principle:

```php

<?php

use GetSky\ParserExpressions\Rules\FirstOf;
use GetSky\ParserExpressions\Rules\Optional;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Runner;
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Error;

require_once '../vendor/autoload.php';

$rule = new Sequence([new FirstOf(['Hello', 'Hi']), new Optional(' '), 'world']);
$runner = new Runner(new Context(new Error()), $rule);

$result = $runner->run('Hi world!');

print_r($result->toArray());
```

```
Array
(
    [name] => Sequence
    [value] => Hi world
    [start] => 0
    [end] => 8
    [children] => Array
        (
            [0] => Array
                (
                    [name] => FirstOf
                    [value] => Hi
                    [start] => 0
                    [end] => 2
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [name] => String
                                    [value] => Hi
                                    [start] => 0
                                    [end] => 2
                                )

                        )

                )

            [1] => Array
                (
                    [name] => Optional
                    [value] =>  
                    [start] => 2
                    [end] => 3
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [name] => String
                                    [value] =>  
                                    [start] => 2
                                    [end] => 3
                                )

                        )

                )

            [2] => Array
                (
                    [name] => String
                    [value] => world
                    [start] => 3
                    [end] => 8
                )

        )

)
```

More example
------------
See more examples in this [folder](https://github.com/JimmDiGrizli/RoyalStag/tree/develop/example).

