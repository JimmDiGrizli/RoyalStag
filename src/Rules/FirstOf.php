<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;

/**
 * This rule is triggered at the first match.The choice operator e1 / e2
 * first invokes e1, and if e1 succeeds, returns its result immediately.
 * Otherwise, if e1 fails, then the choice operator backtracks to the
 * original input position at which it invoked e1, but then calls e2
 * instead, returning e2's result.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
 */
class FirstOf extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\RuleInterface[] Array with subrules.
     */
    protected $rules;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param array $rules Array with subrules.
     * @param string $name Label for rule.
     * @param callable $action
     */
    public function __construct(array $rules, $name = "FirstOf", callable $action = null)
    {
        foreach ($rules as $rule) {
            $this->rules[] = $this->toRule($rule);
        }
        $this->name = (string) $name;
        $this->action = $action;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();
        $context->increaseDepth();

        foreach ($this->rules as $rule) {
            $value = $rule->scan($context);
            if ($value instanceof Result) {
                $result = new Result($this->name);
                $result->addChild($value);
                $result->setValue($value->getValue(), $index);
                $this->action($result);

                return $result;
            }
            $context->setCursor($index);
        }

        $context->decreaseDepth();
        $context->setCursor($index);
        $context->error($this, $index);
        return false;
    }
}
