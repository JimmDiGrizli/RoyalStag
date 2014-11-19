<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
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
     * @var string
     */
    protected $name;

    /**
     * @param array $rules Array with subrules
     * @param string $name Name of rule
     */
    public function __construct(array $rules, $name = "FirstOf")
    {
        $this->rules = $rules;
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

        foreach ($this->rules as $rule) {
            $value = $rule->scan($context);
            if ($value !== false) {
                $result = new Result($this->name);
                $result->addChild($value);
                $result->setValue($value->getValue(), $index);
                return $result;
            }
            $context->setCursor($index);
        }

        $context->setCursor($index);
        return false;
    }
}
