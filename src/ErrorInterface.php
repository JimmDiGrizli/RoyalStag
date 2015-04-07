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
     */
    public function update(RuleInterface $rule, $index);

    public function __clone();
}
