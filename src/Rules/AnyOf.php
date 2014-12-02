<?php
/**
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\RuleInterface;

/**
 * This rule is triggered at the first matched char of input chars.
 */
class AnyOf implements RuleInterface
{

    /**
     * @var string String with chars.
     */
    protected $rule;

    /**
     * @var string
     */

    protected $name;

    /**
     * @param string $rule String with chars.
     * @param string $name Label for rule.
     */
    public function __construct($rule, $name = "AnyOf")
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
        $len = strlen($this->rule);

        for ($i = 0; $i <= $len; ++$i) {
            $char = $context->value();

            if ($char == $this->rule{$i}) {
                $result = new Result($this->name);
                $result->setValue($char, $index);
                return $result;
            }

            $context->setCursor($index);
        };

        $context->setCursor($index);
        return false;
    }
}
