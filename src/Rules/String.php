<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 * @package GetSky\ParserExpressions\Rules
 */
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;

/**
 * It's rule that only succeeds if strings are equal.
 */
class String extends AbstractRule
{

    /**
     * @var string
     */
    protected $rule;

    /**
     * @param string|int $rule String rule
     * @param callable $action
     * @param string|int $name
     */
    public function __construct($rule, $name = "String", callable $action = null)
    {
        $this->rule = (string)$rule;
        $this->name = (string)$name;
        $this->action = $action;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();

        $string = $context->value(strlen($this->rule));

        if ($string !== $this->rule) {
            $context->setCursor($index);
            $context->error($this, $index);

            return false;
        }

        $result = new Result($this->name);
        $result->setValue($string, $index);
        $this->action();

        return $result;
    }
}
