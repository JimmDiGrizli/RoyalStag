<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rule;

/**
 * The one-or-more operators consume one or more consecutive
 * repetitions of their sub-expression e.
 *
 * @package GetSky\ParserExpressions\Rules
 */
class OneOrMore implements Rule
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
    public function __construct(Rule $rule, $name = "OneOrMore")
    {
        $this->rule = $rule;
        $this->name = (string)$name;
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
        $preIndex = $index = $context->getCursor();
        $index = $index = $context->getCursor();

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

        if ($preIndex != $index) {
            $result->setValue($string, $index);
            return $result;
        }

        return false;
    }
}
