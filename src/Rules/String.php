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

    /**
     * @var string
     */
    protected $rule;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $rule String rule
     * @param string $name
     */
    public function __construct($rule, $name = "String")
    {
        $this->rule = (string) $rule;
        $this->name = (string) $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Checks the string for transmission $context.
     *
     * @param Context $context
     * @return boolean
     */
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