<?php
/**
 * A parser that processes the query string of a URL.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Parser;

/**
 * A parser that processes the query string of a URL.
 */
class QueryParser extends ParserAbstract
{
    /**
     * Forward parser logic to the concrete implementation.
     *
     * @param mixed $url
     * @return array
     * @throws \InvalidArgumentException when $url is not an array
     */
    protected function applyParser($url)
    {
        if (!is_array($url)) {
            throw new \InvalidArgumentException(
                'Expected url to be an array: ' . gettype($url)
            );
        }

        if (isset($url['query'])) {
            parse_str($url['query'], $query);
            $url['query'] = $query;
        } else {
            $url['query'] = array();
        }

        $url['queryKeys'] = array_keys($url['query']);

        return $url;
    }
}
