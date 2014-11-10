<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 *  If the subrule does not match at least once this rule fails.
 *
 * @package GetSky\ParserExpressions\Rules
 */
class OneOrMore implements Rule
{

    /**
     * @var \GetSky\ParserExpressions\Rule[] Array with subrules
     */
    protected $rule;

    /**
     * @param Rule $rule subrule
     */
    public function __construct(Rule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * Checks the rules for transmission $context.
     *  If the subrule does not match at least once this rule fails.
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
