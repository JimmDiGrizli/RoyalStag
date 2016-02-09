<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

interface ErrorCollectionInterface
{

    /**
     * Add error information.
     *
     * @param $rule RuleInterface
     * @param $index int
     */
    public function add(RuleInterface $rule, $index);

    /**
     * Find the most distant errors.
     *
     * @return ParsingErrorInterface
     */
    public function findMaxErrors();

    /**
     * Delete all errors.
     */
    public function clear();
}
