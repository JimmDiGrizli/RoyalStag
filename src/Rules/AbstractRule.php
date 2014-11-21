<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rule;

/**
 * Class AbstractRule
 * Abstract class that contains the method of reduction to the rule.
 *
 * @package GetSky\ParserExpressions\Rules
 */
abstract class AbstractRule implements Rule
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Context $context
     * @return Result|boolean
     */
    abstract public function scan(Context $context);

    /**
     * The method converts $rule to Rule.
     * @param $rule
     * @return Rule
     */
    protected function toRule($rule)
    {
        if ($rule instanceof Rule) {
            return $rule;
        }
        if (is_array($rule)) {
            return new Sequence($rule);
        }
        return new String($rule);
    }
}