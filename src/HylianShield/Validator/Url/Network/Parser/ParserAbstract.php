<?php
/**
 * Abstract implementation for URL parsers.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Parser;

/**
 * Abstract implementation for URL parsers.
 */
abstract class ParserAbstract implements ParserInterface
{
    /**
     * Parse a given url into an array structure with URL components.
     *
     * @param mixed $value
     * @return array
     * @throws ParserException when the parser fails to process the supplied
     *   input.
     */
    final public function parse($value)
    {
        try {
            $value = $this->applyParser($value);
        } catch (\Exception $e) {
            throw new ParserException(
                $e->getMessage(),
                E_ERROR,
                $e
            );
        }

        if (!is_array($value)) {
            throw new ParserException(
                'Internal parser could not create a proper array structure'
            );
        }

        return $value;
    }

    /**
     * Forward parser logic to the concrete implementation.
     *
     * @param mixed $url
     * @return array
     */
    abstract protected function applyParser($url);
}
