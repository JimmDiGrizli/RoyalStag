<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * It's rule that only succeeds if all of its subrule succeed, one after the
 * other.
 *
 * @package GetSky\ParserExpressions\Rules
 */
class Sequence implements Rule
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
     * Checks the rules for transmission $context. If at least one rule is not
     * satisfied, then rolls back the cursor to initial position.
     *
     * @param Context $context
     * @return boolean
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();

        foreach ($this->rules as $rule) {
            if (!$rule->scan($context)) {
                $context->setCursor($index);
                return false;
            }
        }

        return true;
    }
}
