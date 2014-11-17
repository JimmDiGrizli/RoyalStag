<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * The one-or-more operators consume one or more consecutive 
 * repetitions of their sub-expression e. 
 *
 * @package GetSky\ParserExpressions\Rules
 */
class OneOrMore implements Rule
{

    /**
     * @var \GetSky\ParserExpressions\Rule
     */
    protected $rule;

    /**
     * @param Rule $rule
     */
    public function __construct(Rule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * Checks the rules for transmission $context.
     *
     * @param Context $context
     * @return boolean
     */
    public function scan(Context $context)
    {
        $firstIndex = $index = $context->getCursor();

        while ($this->rule->scan($context)) {
            $index = $context->getCursor();
        }

        $context->setCursor($index);

        if($firstIndex != $index) {
            return true;
        }

        return false;
    }
}
