<?php
/**
 * Validate subsets of character ranges.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\String;

use \LogicException;

/**
 * Subset.
 */
abstract class Subset extends \HylianShield\Validator\Range\Mutable
{
    /**
     * The character encoding to use when decoding entities.
     *
     * @const string ENCODING
     */
    const ENCODING = 'UTF-8';

    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'string_subset';

    /**
     * The callable to return the length of the value.
     *
     * @var callable $lengthCheck
     */
    protected $lengthCheck = 'mb_strlen';

    /**
     * The hexadecimal boundaries of the active ranges.
     *
     * @var array $ranges
     */
    protected $ranges = array();

    /**
     * Create a validator based on the ranges written in the current validator.
     *
     * @return callable
     */
    final protected function createValidator()
    {
        // Keep track of encoding settings.
        $encoding = $this::ENCODING;
        $originalEncoding = mb_regex_encoding();

        // Create a pattern based on the active range of this subset.
        $pattern = preg_quote(implode('', $this->getRange()), '/');
        $pattern = "/^[{$pattern}]+$/um";

        // If the internal and current regex encoding don't match, use a specialized validator.
        if ($encoding !== $originalEncoding) {
            return function ($subject) use ($pattern, $encoding, $originalEncoding) {
                // Set the regex encoding to an encoding that supports our range.
                mb_regex_encoding($encoding);

                // Check if the subject matches the pattern.
                $valid = is_string($subject) && (
                    $subject === '' || preg_match($pattern, $subject)
                );

                // Restore it to the previous encoding.
                mb_regex_encoding($originalEncoding);

                return $valid;
            };
        }

        // Return a simplified validator.
        return function ($subject) use ($pattern) {
            return is_string($subject) && (
                $subject === '' || preg_match($pattern, $subject)
            );
        };
    }

    /**
     * Will return a prepared list containing the range of valid characters.
     * The characters are represented by decimals.
     *
     * @return array $rv
     * @throws \LogicException when $this->ranges is empty or not an array.
     */
    final public function getRange()
    {
        // Check if the implementation is in place.
        if (!is_array($this->ranges) || empty($this->ranges)) {
            throw new LogicException(
                'No character ranges implemented. Expected list of ranges in $this->ranges.'
            );
        }

        $rv = array();
        $encoding = $this::ENCODING;

        // Walk through all ranges.
        foreach ($this->ranges as $range) {
            if (!is_array($range) || count($range) !== 2) {
                throw new LogicException(
                    'Invalid range encountered: (' . gettype($range) . ') '
                    . var_export($range, true)
                );
            }

            list($start, $end) = $range;

            // Walk through the active range and apply that to the return value.
            $rv = array_merge(
                $rv,
                array_map(
                    function ($decimal) use ($encoding) {
                        return html_entity_decode(
                            "&#{$decimal};",
                            ENT_QUOTES,
                            $encoding
                        );
                    },
                    // Generate a range based off the hex value.
                    range(hexdec($start), hexdec($end))
                )
            );
        }

        return $rv;
    }
}
