<?php
namespace GetSky\ParserExpressions;

/**
 * Interface for parsing rules.
 *
 * @package GetSky\ParserExpressions
 */
interface Rule
{
    /**
     * @param Context $context
     * @return Result|boolean
     */
    public function scan(Context $context);
}
