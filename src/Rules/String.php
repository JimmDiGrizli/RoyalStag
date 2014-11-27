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
     * @param string|int $name
     */
    public function __construct($rule, $name = "String")
    {
        $this->rule = (string)$rule;
        $this->name = (string)$name;
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
            return false;
        }

        $result = new Result($this->name);
        $result->setValue($string, $index);

        return $result;
    }
}
