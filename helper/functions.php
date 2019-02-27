<?php

use GetSky\ParserExpressions\RuleInterface;
use GetSky\ParserExpressions\Rules\Any;
use GetSky\ParserExpressions\Rules\AnyOf;
use GetSky\ParserExpressions\Rules\EOI;
use GetSky\ParserExpressions\Rules\FirstOf;
use GetSky\ParserExpressions\Rules\OneOrMore;
use GetSky\ParserExpressions\Rules\Optional;
use GetSky\ParserExpressions\Rules\PredicateAnd;
use GetSky\ParserExpressions\Rules\PredicateNot;
use GetSky\ParserExpressions\Rules\Range;
use GetSky\ParserExpressions\Rules\Sequence;
use GetSky\ParserExpressions\Rules\Row;
use GetSky\ParserExpressions\Rules\ZeroOrMore;

/**
 * Syntactic sugar to create an object of class FirstOf.
 *
 * @param array $rules
 * @param string $name
 * @param callable $action
 * @return FirstOf
 */
function FirstOf(array $rules, $name = "FirstOf", callable $action = null)
{
    return new FirstOf($rules, $name, $action);
}

/**
 * Syntactic sugar to create an object of class OneOrMore.
 *
 * @param RuleInterface $rule
 * @param string $name
 * @param callable $action
 * @return OneOrMore
 */
function OneOrMore($rule, $name = "OneOrMore", callable $action = null)
{
    return new OneOrMore($rule, $name, $action);
}

/**
 * Syntactic sugar to create an object of class Optional.
 *
 * @param RuleInterface $rule
 * @param string $name
 * @param callable $action
 * @return Optional
 */
function Optional($rule, $name = "Optional", callable $action = null)
{
    return new Optional($rule, $name, $action);
}

/**
 * Syntactic sugar to create an object of class Sequence.
 *
 * @param array $rules
 * @param string $name
 * @param callable $action
 * @return Sequence
 */
function Sequence(array $rules, $name = "Sequence", callable $action = null)
{
    return new Sequence($rules, $name, $action);
}

/**
 * Syntactic sugar to create an object of class String.
 *
 * @param $string
 * @param string $name
 * @param callable $action
 * @return GetSky\ParserExpressions\Rules\Row
 */
function Row($string, $name = "String", callable $action = null)
{
    return new Row($string, $name, $action);
}

/**
 * Syntactic sugar to create an object of class ZeroOrMore.
 *
 * @param string|array|RuleInterface $rule
 * @param string $name
 * @param callable $action
 * @return ZeroOrMore
 */
function ZeroOrMore($rule, $name = "ZeroOrMore", callable $action = null)
{
    return new ZeroOrMore($rule, $name, $action);
}

/**
 * Syntactic sugar to create an object of class PredicateAnd.
 *
 * @param RuleInterface $rule
 * @param string $name
 * @return PredicateAnd
 */
function PredicateAnd($rule, $name = "PredicateAnd")
{
    return new PredicateAnd($rule, $name);
}

/**
 * Syntactic sugar to create an object of class PredicateNot.
 *
 * @param RuleInterface $rule
 * @param string $name
 * @return PredicateNot
 */
function PredicateNot($rule, $name = "PredicateNot")
{
    return new PredicateNot($rule, $name);
}

/**
 * Syntactic sugar to create an object of class Range.
 *
 * @param string|int $left
 * @param string|int $right
 * @param string $name
 * @param callable $action
 * @return Range
 */
function CharRange($left, $right, $name = "Range", callable $action = null)
{
    return new Range($left, $right, $name, $action);
}

/**
 * Syntactic sugar to create an object of class AnyOf.
 *
 * @param string|int $string
 * @param string $name
 * @return AnyOf
 */
function AnyOf($string, $name = "AnyOf")
{
    return new AnyOf($string, $name);
}

/**
 * Syntactic sugar to create an object of class Any.
 *
 * @return Any
 */
function Any()
{
    return new Any();
}

/**
 * Syntactic sugar to create an object of class EOI.
 *
 * @return Eoi
 */
function EOI()
{
    return new Eoi();
}
