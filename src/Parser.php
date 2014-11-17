<?php
namespace GetSky\ParserExpressions;

class Parser
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var Rule
     */
    protected $rule;

    /**
     * @param Rule $rule
     */
    public function __construct(Rule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * @param string $string
     * @return bool
     */
    public function run($string)
    {
        $this->context = new Context($string);
        return $this->rule->scan($this->context);
    }
}
