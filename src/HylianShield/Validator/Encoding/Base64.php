<?php
/**
 * Validate Base64 encoded data.
 *
 * @package HylianShield
 * @subpackage Validator
 * @see http://tools.ietf.org/html/rfc4648
 */

namespace HylianShield\Validator\Encoding;

use \InvalidArgumentException;

/**
 * Base64 encoding validator.
 */
class Base64 extends \HylianShield\Validator
{
    /**
     * Pass this option to validate the padding on the right side of encoded strings.
     *
     * @var integer VALIDATE_PADDING
     * @see http://tools.ietf.org/html/rfc4648#section-3.2
     */
    const VALIDATE_PADDING = 1;

    /**
     * Pass this option if we will allow carriage return and line feed characters,
     * as described in RFC 4648, which is commonly used by MIME and PEM.
     *
     * @var integer ALLOW_CRLF
     * @see http://tools.ietf.org/html/rfc4648#section-3.1
     */
    const ALLOW_CRLF = 2;

    /**
     * The padding character.
     *
     * @var string PADDING
     * @see http://tools.ietf.org/html/rfc4648#section-3.2
     */
    const PADDING = '=';

    /**
     * The maximum amount of padding characters at the end of an encoding.
     * Padding at the end of the data is performed using the '=' character.
     * Since all base 64 input is an integral number of octets, only the following
     * cases can arise:
     *
     * (1) The final quantum of encoding input is an integral multiple of 24
     *     bits; here, the final unit of encoded output will be an integral
     *     multiple of 4 characters with no "=" padding.
     *
     * (2) The final quantum of encoding input is exactly 8 bits; here, the
     *     final unit of encoded output will be two characters followed by
     *     two "=" padding characters.
     *
     * (3) The final quantum of encoding input is exactly 16 bits; here, the
     *     final unit of encoded output will be three characters followed by
     *     one "=" padding character.
     *
     * @var integer MAX_PADDING
     * @see http://tools.ietf.org/html/rfc4648#section-4
     */
    const MAX_PADDING = 2;

    /**
     * The amount of characters required to represent an encoding group.
     * The encoding process represents 24-bit groups of input bits as output
     * strings of 4 encoded characters.  Proceeding from left to right, a
     * 24-bit input group is formed by concatenating 3 8-bit input groups.
     * These 24 bits are then treated as 4 concatenated 6-bit groups, each
     * of which is translated into a single character in the base 64
     * alphabet.
     *
     * @var integer NUM_CHARACTERS_PER_GROUP
     * @see http://tools.ietf.org/html/rfc4648#section-4
     */
    const NUM_CHARACTERS_PER_GROUP = 4;

    /**
     * The validator type.
     *
     * @var string $type
     */
    protected $type = 'encoding_base64';

    /**
     * Whether the padding will be validated.
     *
     * @var boolean $validatePadding
     * @see http://tools.ietf.org/html/rfc4648#section-3.2
     */
    protected $validatePadding;

    /**
     * Whether we allow line feeds in the encoded data.
     *
     * @var boolean $allowCRLF
     * @see http://tools.ietf.org/html/rfc4648#section-3.1
     */
    protected $allowCRLF;

    /**
     * The lineFeedCharacters.
     *
     * @var array $lineFeedCharacters
     * @see http://tools.ietf.org/html/rfc4648#section-3.1
     */
    private $lineFeedCharacters;

    /**
     * A list of valid characters.
     *
     * @var array $validCharacters
     * @see http://tools.ietf.org/html/rfc4648#section-4
     */
    private $validCharacters;

    /**
     * The constructor for Base64.
     *
     * @param integer $options validation options.
     */
    public function __construct($options = self::VALIDATE_PADDING)
    {
        $this->setOptions($options);

        // Set the validator.
        $this->validator = array($this, 'validateMessage');
    }

    /**
     * Set the options for the validator.
     *
     * @param integer $options validation options.
     * @return void
     * @throws \InvalidArgumentException when $options is not an integer
     */
    final protected function setOptions($options)
    {
        if (!is_integer($options)) {
            throw new InvalidArgumentException('Options should be an integer');
        }

        // Set the options flags.
        $this->validatePadding = (bool) ($options & $this::VALIDATE_PADDING);
        $this->allowCRLF = (bool) ($options & $this::ALLOW_CRLF);
    }

    /**
     * Setter for lineFeedCharacters.
     *
     * @param array $lineFeedCharacters
     * @return void
     */
    final protected function setLineFeedCharacters(array $lineFeedCharacters)
    {
        $this->lineFeedCharacters = $lineFeedCharacters;
    }

    /**
     * Return the line feed characters for this encoding.
     *
     * @return array $this->lineFeedCharacters
     * @see http://tools.ietf.org/html/rfc4648#section-3.1
     */
    final protected function getLineFeedCharacters()
    {
        if (!isset($this->lineFeedCharacters)) {
            $this->setLineFeedCharacters(array("\r", "\n"));
        }

        return $this->lineFeedCharacters;
    }

    /**
     * Setter for validCharacters.
     *
     * @param array $validCharacters
     * @return void
     */
    final protected function setValidCharacters(array $validCharacters)
    {
        $this->validCharacters = $validCharacters;
    }

    /**
     * Get a list of valid characters. Does the setup if the list is absent.
     *
     * @return array $this->validCharacters
     * @see http://tools.ietf.org/html/rfc4648#section-4
     */
    final protected function getValidCharacters()
    {
        if (!isset($this->validCharacters)) {
            $this->setValidCharacters(
                // The Base 64 alphabet.
                array_merge(
                    // A-Z.
                    range('A', 'Z'),
                    // a-z.
                    range('a', 'z'),
                    // 0-9.
                    array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
                    // + and /.
                    array('+', '/')
                )
            );
        }

        return $this->validCharacters;
    }

    /**
     * Validate the given message.
     *
     * @param mixed $message
     * @return boolean
     */
    final protected function validateMessage($message)
    {
        // Base64 is encoded in a string.
        if (!is_string($message)) {
            return false;
        }

        // If the validator allows for line feeds, that would mess up our calculations.
        // If so, we must remove them right now.
        if ($this->allowCRLF) {
            $message = $this->removeLineFeeds($message);
        }

        // If the padding should be validated, do so now.
        if ($this->validatePadding && !$this->validatePadding($message)) {
            return false;
        }

        // The padding characters may not occur within the encoding.
        $message = $this->trimPadding($message);
        $length = strlen($message);
        $validCharacters = $this->getValidCharacters();

        // Check all characters inside the message.
        for ($c = 0; $c < $length; $c++) {
            if (!in_array($message[$c], $validCharacters, true)) {
                return false;
            }
        }

        // All rules are satisfied.
        return true;
    }

    /**
     * Trim the padding from a given message.
     *
     * @param string $message
     * @return string
     */
    final protected function trimPadding($message)
    {
        // Base64 only has a padding on the right side of the string.
        // That is why we use rtrim to only trim off on the right side.
        return rtrim($message, $this::PADDING);
    }

    /**
     * Remove line feeds from the given message.
     *
     * @param string $message
     * @return string
     */
    final protected function removeLineFeeds($message)
    {
        return str_replace($this->getLineFeedCharacters(), '', $message);
    }

    /**
     * Validate the padding of a given message.
     *
     * @param string
     * @return boolean
     */
    final protected function validatePadding($message)
    {
        $length = strlen($message);

        // The length should always be a multitude of the amount of characters
        // per group if padding is applied.
        if (($length % $this::NUM_CHARACTERS_PER_GROUP) !== 0) {
            return false;
        }

        // Determine the length of the message without padding characters.
        $trimmedLength = strlen($this->trimPadding($message));

        // There is a maximum to the padding we can encounter.
        if (($length - $trimmedLength) > $this::MAX_PADDING) {
            return false;
        }

        // All rules are satisfied.
        return true;
    }
}
