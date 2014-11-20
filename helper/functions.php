<?php

use GetSky\ParserExpressions\Rule;
use GetSky\ParserExpressions\Rules\FirstOf;
use GetSky\ParserExpressions\Rules\OneOrMore;
use GetSky\ParserExpressions\Rules\Optional;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\String;
use GetSky\ParserExpressions\Rules\ZeroOrMore;

/**
 * Syntactic sugar to create an object of class FirstOf.
 *
 * @param array $rules
 * @param string $name
 * @return FirstOf
 */
function FirstOf(array $rules, $name = "FirstOf")
{
    return new FirstOf($rules, $name);
}

/**
 * Syntactic sugar to create an object of class OneOrMore.
 *
 * @param Rule $rule
 * @param string $name
 * @return OneOrMore
 */
function OneOrMore(Rule $rule, $name = "OneOrMore")
{
    return new OneOrMore($rule, $name);
}

/**
 * Syntactic sugar to create an object of class Optional.
 *
 * @param Rule $rule
 * @param string $name
 * @return Optional
 */
function Optional(Rule $rule, $name = "Optional")
{
    return new Optional($rule, $name);
}

/**
 * Syntactic sugar to create an object of class Sequence.
 *
 * @param array $rules
 * @param string $name
 * @return Sequence
 */
function Sequence(array $rules, $name = "Sequence")
{
    return new Sequence($rules, $name);
}

/**
 * Syntactic sugar to create an object of class String.
 *
 * @param $string
 * @param string $name
 * @return GetSky\ParserExpressions\Rules\String
 */
function String($string, $name = "String")
{
    return new String($string, $name);
}

/**
 * Syntactic sugar to create an object of class ZeroOrMore.
 *
 * @param Rule $rule
 * @param string $name
 * @return ZeroOrMore
 */
function ZeroOrMore(Rule $rule, $name = "ZeroOrMore")
{
    return new ZeroOrMore($rule, $name);
}

