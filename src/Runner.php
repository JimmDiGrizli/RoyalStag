<?php
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
     * @param RuleInterface $rule
     */
    public function __construct(RuleInterface $rule)
    {
        $this->rule = $rule;
    }

    /**
     * @param string $string
     * @return bool|Result
     */
    public function run($string)
    {
        $this->context = new Context($string);
        return $this->rule->scan($this->context);
    }
}
