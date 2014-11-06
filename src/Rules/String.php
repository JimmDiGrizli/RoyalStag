<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * It's rule that only succeeds if strings are equal.
 *
 * @package GetSky\ParserExpressions\Rules
 */
class String implements Rule
{

    protected $rule;

    /**
     * @param string $rule String rule
     */
    public function __construct($rule)
    {
        $this->rule = (string) $rule;
    }

    public function scan(Context $context)
    {
        $index = $context->getCursor();

        $string = $context->value(strlen($this->rule));

        if ($string != $this->rule) {
            $context->setCursor($index);
            return false;
        }

        return true;
    }
}