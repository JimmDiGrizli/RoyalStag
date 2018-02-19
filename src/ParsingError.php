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

    private $depth;

    public function __construct(RuleInterface $rule, $index, $depth)
    {
        $this->index = $index;
        $this->rule = $rule;
        $this->depth = $depth;
    }

    public function rule()
    {
        return $this->rule;
    }

    public function position()
    {
        return $this->index;
    }

    public function depth()
    {
        return $this->depth;
    }
}
