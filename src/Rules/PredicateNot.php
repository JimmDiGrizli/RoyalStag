<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rule;

/**
 * The not-predicate expression !e succeeds if e fails and fails if e succeeds,
 * again consuming no input in either case.
 *
 * @package GetSky\ParserExpressions\Rules
 */
class PredicateNot extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\Rule
     */
    protected $rule;

    /**
     * @param array|string|Rule $rule
     * @param string $name
     */
    public function __construct($rule, $name = "PredicateNot")
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
        $context->setCursor($index);

        if ($value === false) {
            return true;
        }
        return false;
    }
}