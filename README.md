RoyalStag
=========
[![Build Status](https://travis-ci.org/JimmDiGrizli/RoyalStag.svg)](https://travis-ci.org/JimmDiGrizli/RoyalStag)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JimmDiGrizli/RoyalStag/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/JimmDiGrizli/RoyalStag/?branch=develop)

In computer science, a parsing expression grammar, or [PEG](http://en.wikipedia.org/wiki/Parsing_expression_grammar "Parsing expression grammar"), is a type of analytic formal grammar, i.e. it describes a formal language in terms of a set of rules for recognizing strings in the language. The formalism was introduced by Bryan Ford in 2004 and is closely related to the family of top-down parsing languages introduced in the early 1970s. Syntactically, PEGs also look similar to context-free grammars (CFGs), but they have a different interpretation: the choice operator selects the first match in PEG, while it is ambiguous in CFG. This is closer to how string recognition tends to be done in practice, e.g. by a recursive descent parser.


```php

<?php

use GetSky\ParserExpressions\Rules\FirstOf;
use GetSky\ParserExpressions\Rules\Optional;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Runner;

require_once '../vendor/autoload.php';

$runner = new Runner(new Sequence([new FirstOf(['s', 'd']), new Optional('ab'), 'cd']));

$result = $runner->run('dabcd');

print_r($result->toArray());
```

```
Array
(
    [name] => Sequence
    [value] => dabcd
    [start] => 0
    [end] => 5
    [children] => Array
        (
            [0] => Array
                (
                    [name] => FirstOf
                    [value] => d
                    [start] => 0
                    [end] => 1
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [name] => String
                                    [value] => d
                                    [start] => 0
                                    [end] => 1
                                )

                        )

                )

            [1] => Array
                (
                    [name] => Optional
                    [value] => ab
                    [start] => 1
                    [end] => 3
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [name] => String
                                    [value] => ab
                                    [start] => 1
                                    [end] => 3
                                )

                        )

                )

            [2] => Array
                (
                    [name] => String
                    [value] => cd
                    [start] => 3
                    [end] => 5
                )

        )

)
```
