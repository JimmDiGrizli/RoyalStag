<?php
/**
 * @package GetSky\ParserExpressions
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
namespace GetSky\ParserExpressions;

/**
 * Interface for parsing rules.
 */
interface ResultInterface
{
    /**
     * Added child result
     *
     * @param Result $child
     */
    public function addChild(Result $child);

    /**
     * Outstanding results in an array.
     *
     * @return array
     */
    public function toArray();
}
