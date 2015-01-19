<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

interface ErrorInterface
{

    /**
     * Update error information
     *
     * @param $rule RuleInterface
     * @param $index int
     * @param $text string
     */
    public function update(RuleInterface $rule, $index, $text);

    /**
     * Remove all information about the error
     */
    public function clear();

    /**
     * Indicates whether the modification.
     * @return boolean
     */
    public function isChanged();
}
