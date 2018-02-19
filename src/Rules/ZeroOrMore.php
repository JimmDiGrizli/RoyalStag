<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\RuleInterface;

/**
 * The zero-or-more operators consume zero or more consecutive
 * repetitions of their sub-expression e. These operators always
 * behave greedily, consuming as much input as possible and never
 * backtracking.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
 */
class ZeroOrMore extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\RuleInterface
     */
    protected $rule;

    /**
     * @param array|string|RuleInterface $rule
     * @param string $name
     * @param callable $action
     */
    public function __construct($rule, $name = "ZeroOrMore", callable $action = null)
    {
        $this->rule = $this->toRule($rule);
        $this->name = (string) $name;
        $this->action = $action;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $firstIndex = $index = $context->getCursor();
        $string = '';
        $result = new Result($this->name);

        $context->increaseDepth();
        while ($value = $this->rule->scan($context)) {
            if ($value instanceof Result) {
                $result->addChild($value);
                $string .= $value->getValue();
                $index = $context->getCursor();
            }
        }
        $context->decreaseDepth();
        $context->setCursor($index);

        if ($firstIndex != $index) {
            $result->setValue($string, $firstIndex);
            $this->action($result);
            return $result;
        }

        return true;
    }
}
