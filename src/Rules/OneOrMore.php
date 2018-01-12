<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\RuleInterface;

/**
 * The one-or-more operators consume one or more consecutive
 * repetitions of their sub-expression e.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
class OneOrMore extends AbstractRule
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
    public function __construct($rule, $name = "OneOrMore", callable $action = null)
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
            $this->action($result);
            return $result;
        }

        $context->error($this, $index);
        return false;
    }
}
