RoyalStag
=========
[![Build Status](https://travis-ci.org/JimmDiGrizli/RoyalStag.svg)](https://travis-ci.org/JimmDiGrizli/RoyalStag)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JimmDiGrizli/RoyalStag/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/JimmDiGrizli/RoyalStag/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/g/JimmDiGrizli/RoyalStag/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/JimmDiGrizli/RoyalStag/?branch=develop)

RoyalStag is a PHP library for parsing text realizes the strengths of parsing expression grammar, or [PEG](http://en.wikipedia.org/wiki/Parsing_expression_grammar "Parsing expression grammar"). The main feature is the grammar, which is set directly in the code of PHP. This means that you do not need to learn any third-party formats to start using the library, and you do not lose the opportunities that gives you your favorite IDE (syntax highlighting, refactoring, etc.).

####Easy integration into your projects

To integrate the library into your project, you will not have to spend a lot of time and effort. The open and flexible architecture easily integrates into any architectural solution, as there is no need for third-party tools to generate a parser. The only thing you have to do is add one line composer.json:

```
"getsky/royal-stag": "0.9.*@dev"
```


####Why not regular expressions?

In many cases, it also lacks the ability to parse the text, such as embedded designs that require a recursive definition of the rules. They also do not provide appropriate error messages, and it can save a lot of time both during development and in support of software. And of course the ease of learning.


####Why not ANTLR and other enterprise?

ANTLR and others like it may all libraries that can RoyalStag and even more, but not always appropriate to use such a large library, which require much more time to study, develop with them and their continued support of software products.

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
$runner = new Runner($rule);

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
                                    [name] => Row
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
                                    [name] => Row
                                    [value] =>
                                    [start] => 2
                                    [end] => 3
                                )

                        )

                )

            [2] => Array
                (
                    [name] => Row
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


