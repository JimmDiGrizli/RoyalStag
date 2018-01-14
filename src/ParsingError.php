<?php
/**
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

/**
 * It is a error result for parsing string.
 */
class ParsingError implements ParsingErrorInterface
{

    protected $rule;

    protected $index;

    public function __construct(RuleInterface $rule, $index)
    {
        $this->index = $index;
        $this->rule = $rule;
    }

    public function rule()
    {
        return $this->rule;
    }

    public function position()
    {
        return $this->index;
    }
}
