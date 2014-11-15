<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * This rule is triggered at the first match.The choice operator e1 / e2 
 * first invokes e1, and if e1 succeeds, returns its result immediately. 
 * Otherwise, if e1 fails, then the choice operator backtracks to the 
 * original input position at which it invoked e1, but then calls e2 
 * instead, returning e2's result.
 * 
 * @package GetSky\ParserExpressions\Rules
 */
class FirstOf implements Rule
{

    /**
     * @var \GetSky\ParserExpressions\Rule[] Array with subrules
     */
    protected $rules;

    /**
     * @param array $rules Array with subrules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
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

        foreach ($this->rules as $rule) {
            if ($rule->scan($context)) {
               return true;
            }
            $context->setCursor($index);
        }

        $context->setCursor($index);
        return false;
    }
}
