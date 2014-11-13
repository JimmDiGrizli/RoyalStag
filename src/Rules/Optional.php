<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * Rule tries match on its subrule and always succeeds, independently of the
 * matching success of its sub rule.
 *
 * @package GetSky\ParserExpressions\Rules
 */
class Optional implements Rule
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
     * Rule tries match on its subrule and always succeeds,
     * independently of the matching success of its sub rule.
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
