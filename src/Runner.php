<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

class Runner
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var RuleInterface
     */
    protected $rule;

    /**
     * @param Context $context
     * @param RuleInterface $rule
     */
    public function __construct(Context $context, RuleInterface $rule)
    {
        $this->rule = $rule;
        $this->context = $context;
    }

    /**
     * @param string $string
     * @return bool|Result
     */
    public function run($string)
    {
        $this->context->setString($string);

        return $this->rule->scan($this->context);
    }

    /**
     * @return bool|ErrorInterface
     */
    public function hasError()
    {
        if ($error = $this->context->getError()) {
            return $error;
        }

        return false;
    }
}
