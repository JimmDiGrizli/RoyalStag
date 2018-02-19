<?php
/**
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
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
     * @param int $depth
     * @return void
     */
    public function add(RuleInterface $rule, $index, $depth);

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
