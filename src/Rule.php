<?php
namespace GetSky\ParserExpressions;

/**
 * Interface for parsing rules.
 *
 * @package GetSky\ParserExpressions
 */
interface Rule {
    public function scan(Context $context);
}
