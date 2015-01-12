<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\RuleInterface;

/**
 * The and-predicate expression &e invokes the sub-expression e,
 * and then succeeds if e succeeds and fails if e fails, but in
 * either case never consumes any input.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
class PredicateAnd extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\RuleInterface
     */
    protected $rule;

    /**
     * @param array|string|RuleInterface $rule
     * @param string $name
     */
    public function __construct($rule, $name = "PredicateAnd")
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

        if ($value === false) {
            $context->error($this, $index);
            return false;
        }

        return true;
    }
}
