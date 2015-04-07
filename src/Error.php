<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

/**
 * It is a error result for parsing string.
 */
class Error implements ErrorInterface
{

    protected $rule;

    protected $index;

    /**
     * {@inheritdoc}
     */
    public function update(RuleInterface $rule, $index)
    {
        $this->index = $index;
        $this->rule = $rule;
    }

    public function __clone()
    {
        $this->index = null;
        $this->rule = null;
    }
}
