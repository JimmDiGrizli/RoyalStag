<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
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
