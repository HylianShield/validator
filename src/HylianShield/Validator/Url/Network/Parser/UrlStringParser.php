<?php
/**
 * Parse URL strings into URL structures.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Parser;

/**
 * Parse URL strings into URL structures.
 */
class UrlStringParser extends ParserAbstract
{
    /**
     * Forward parser logic to the concrete implementation.
     *
     * @param mixed $url
     * @return array
     * @throws \InvalidArgumentException when $url is not a string
     */
    protected function applyParser($url)
    {
        // Support VALOs for URLs.
        if (is_object($url) && method_exists($url, '__toString')) {
            $url = (string) $url;
        }

        if (!is_string($url)) {
            throw new \InvalidArgumentException(
                'Value must be a string: ' . gettype($url)
            );
        }

        return parse_url($url);

    }
}
