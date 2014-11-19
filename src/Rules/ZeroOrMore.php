<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
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
        $firstIndex = $index = $context->getCursor();
        $string = '';
        $result = new Result($this->name);

        while ($value = $this->rule->scan($context)) {
            $result->addChild($value);
            $string .= $value->getValue();
            $index = $context->getCursor();
        }

        $context->setCursor($index);

        if($firstIndex != $index) {
            $result->setValue($string, $index);
            return $result;
        }

        return true;
    }
}
