<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rule;

/**
 * The and-predicate expression &e invokes the sub-expression e,
 * and then succeeds if e succeeds and fails if e fails, but in
 * either case never consumes any input.
 *
 * @package GetSky\ParserExpressions\Rules
 */
class PredicateAnd extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\Rule
     */
    protected $rule;

    /**
     * @param array|string|Rule $rule
     * @param string $name
     */
    public function __construct($rule, $name = "PredicateAnd")
    {
        $this->rule = $this->toRule($rule);
        $this->name = (string)$name;
    }


    /**
     * Checks the rules for transmission $context.
     *
     * @param Context $context
     * @return Result|boolean
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();
        $value = $this->rule->scan($context);


        if ($value === false) {
            $context->setCursor($index);
            return false;
        }
        return true;
    }
}