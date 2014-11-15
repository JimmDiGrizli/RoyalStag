<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * The sequence operator e1 e2 first invokes e1, and if e1 succeeds, 
 * subsequently invokes e2 on the remainder of the input string leftc
 * unconsumed by e1, and returns the result. If either e1 or e2 fails, 
 * then the sequence expression e1 e2 fails.
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
     * Checks the rules for transmission $context.
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
