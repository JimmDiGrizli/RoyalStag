<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * This rule is triggered at the first match.
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
     * Checks the rules for transmission $context. If at all rules is not
     * satisfied, then rolls back the cursor to initial position.
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
