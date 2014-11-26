<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\RuleInterface;

/**
 * The optional operators consume zero or one consecutive
 * repetitions of their sub-expression e.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
class Optional extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\RuleInterface
     */
    protected $rule;

    /**
     * @param array|string|RuleInterface $rule
     * @param string $name
     */
    public function __construct($rule, $name = "Optional")
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

        if (is_bool($value)) {
            if ($value == false) {
                $context->setCursor($index);
            }
            return true;
        }

        $result = new Result($this->name);
        $result->setValue($value->getValue(), $index);
        $result->addChild($value);

        return $result;
    }
}
