<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * Abstract class that contains the method of reduction to the rule.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
abstract class AbstractRule implements Rule
{
    /**
     * @var string The label for the rule.
     */
    protected $name;

    /**
     * Returns the value of the label.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function scan(Context $context);

    /**
     * This method converts the input value to an object that implements an interface Rule.
     *
     * @param $rule
     * @return Rule
     */
    public  function toRule($rule)
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