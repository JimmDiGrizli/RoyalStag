<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\RuleInterface;

/**
 * Abstract class that contains the method of reduction to the rule.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
abstract class AbstractRule implements RuleInterface
{
    /**
     * @var string The label for the rule.
     */
    protected $name;

    /**
     * @var callable The function which is performed after scanning.
     */
    protected $action;

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
     * Launches action.
     *
     * @param Result $result
     * @return void
     */
    public function action(Result $result = null)
    {
        if ($this->action !== null) {
            $action = $this->action;
            $action($result);
        }
    }

    /**
     * {@inheritdoc}
     */
    abstract public function scan(Context $context);

    /**
     * This method converts the input value to an object that implements an interface Rule.
     *
     * @param $rule
     * @return RuleInterface
     */
    public function toRule($rule)
    {
        if ($rule instanceof RuleInterface) {
            return $rule;
        }
        if (is_array($rule)) {
            return new Sequence($rule);
        }
        return new Row($rule);
    }
}
