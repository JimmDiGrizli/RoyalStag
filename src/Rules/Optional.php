<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * The optional operators consume zero or one consecutive 
 * repetitions of their sub-expression e. 
 *
 * @package GetSky\ParserExpressions\Rules
 */
class Optional implements Rule
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
        $index = $context->getCursor();

        if(!$this->rule->scan($context)) {
            $context->setCursor($index);
        }

        return true;
    }
}
