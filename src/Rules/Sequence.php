<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;

/**
 * The sequence operator e1 e2 first invokes e1, and if e1 succeeds,
 * subsequently invokes e2 on the remainder of the input string leftc
 * unconsumed by e1, and returns the result. If either e1 or e2 fails,
 * then the sequence expression e1 e2 fails.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
 */
class Sequence extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\RuleInterface[] Array with subrules.
     */
    protected $rules;

    /**
     * @param array $rules Array with subrules
     * @param string $name
     * @param callable $action
     */
    public function __construct(array $rules, $name = "Sequence", callable $action = null)
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
        $string = '';
        $result = new Result($this->name);

        $context->increaseDepth();
        foreach ($this->rules as $rule) {
            $value = $rule->scan($context);
            if ($value === false) {
                $context->setCursor($index);
                return false;
            } elseif ($value instanceof Result) {
                $string .= $value->getValue();
                $result->addChild($value);
            }
        }
        $context->decreaseDepth();
        $result->setValue($string, $index);
        $this->action($result);

        return $result;
    }
}
