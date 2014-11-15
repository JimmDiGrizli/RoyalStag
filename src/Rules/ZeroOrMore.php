<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * The zero-or-more operators consume zero or more consecutive 
 * repetitions of their sub-expression e. These operators always 
 * behave greedily, consuming as much input as possible and never 
 * backtracking. 
 *
 * @package GetSky\ParserExpressions\Rules
 */
class ZeroOrMore implements Rule
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
     * 
     * @param Context $context
     * @return boolean
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();

        while ($this->rule->scan($context)) {
            $index = $context->getCursor();
        }

        $context->setCursor($index);
        return true;
    }
}
