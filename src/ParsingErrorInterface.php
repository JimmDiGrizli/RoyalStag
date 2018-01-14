<?php
/**
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

interface ParsingErrorInterface
{

    /**
     * Get rule
     *
     * @return RuleInterface
     */
    public function rule();

    /**
     * Update error information
     *
     * @return int
     */
    public function position();
}
