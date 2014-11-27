<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\RuleInterface;

/**
 * The not-predicate expression !e succeeds if e fails and fails if e succeeds,
 * again consuming no input in either case.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
class PredicateNot extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\RuleInterface
     */
    protected $rule;

    /**
     * @param array|string|RuleInterface $rule
     * @param string $name
     */
    public function __construct($rule, $name = "PredicateNot")
    {
        $this->rule = $this->toRule($rule);
        $this->name = (string)$name;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();
        $value = $this->rule->scan($context);
        $context->setCursor($index);

        return $value === false ? true : false;
    }
}
