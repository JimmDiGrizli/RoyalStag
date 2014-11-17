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
     * @var \GetSky\ParserExpressions\Rule
     */
    protected $rule;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param Rule $rule
     * @param string $name
     */
    public function __construct(Rule $rule, $name = "ZeroOrMore")
    {
        $this->rule = $rule;
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
