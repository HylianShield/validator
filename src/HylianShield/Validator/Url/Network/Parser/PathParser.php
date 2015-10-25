<?php
/**
 * A URL parser that processes the path of the URL.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Parser;

/**
 * A URL parser that processes the path of the URL.
 */
class PathParser extends ParserAbstract
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

        $url['path'] = isset($url['path'])
            ? trim($url['path'], '/')
            : '';

        return $url;
    }
}
