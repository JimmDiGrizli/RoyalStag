<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

/**
 * It is a error result for parsing string.
 */
class Error 
{

    protected $rule;

    protected $index;

    protected $text;

    /**
     * @param $rule RuleInterface
     * @param $index int
     * @param $text string
     */
    public function update(RuleInterface $rule, $index, $text)
    {
        $this->index = $index;
        $this->rule = $rule;
        $this->text = $text;
    }

    /**
     *
     */
    public function clear()
    {
        $this->index = null;
        $this->rule = null;
        $this->text = null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Error on {$this->index} symbol near '{$this->text}'.";
    }
}
