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
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
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
     */
    public function __construct($rule, $name = "ZeroOrMore")
    {
        $this->rule = $this->toRule($rule);
        $this->name = (string)$name;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $firstIndex = $index = $context->getCursor();
        $string = '';
        $result = new Result($this->name);

        while ($value = $this->rule->scan($context)) {
            if ($value instanceof Result) {
                $result->addChild($value);
                $string .= $value->getValue();
                $index = $context->getCursor();
            }
        }

        $context->setCursor($index);

        if ($firstIndex != $index) {
            $result->setValue($string, $firstIndex);
            return $result;
        }

        return true;
    }
}
