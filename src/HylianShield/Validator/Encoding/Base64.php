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
     * Whether we will allow carriage return and line feed characters, as described in
     * RFC 4648, which is commonly used by MIME and PEM.
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
     * A list of valid characters.
     *
     * @var array $validCharacters
     */
    private $validCharacters;

    /**
     * The constructor for Base64.
     *
     * @param integer $options validation options.
     * @throws \InvalidArgumentException when $options is not an integer
     */
    public function __construct($options = self::VALIDATE_PADDING)
    {
        if (!is_integer($options)) {
            throw new InvalidArgumentException('Options should be an integer');
        }

        // Set the options flags.
        $this->validatePadding = (bool) ($options & $this::VALIDATE_PADDING);
        $this->allowCRLF = (bool) ($options & $this::ALLOW_CRLF);

        // Set the validator.
        $this->validator = array($this, 'validateMessage');
    }

    /**
     * Get a list of valid characters. Does the setup if the list is absent.
     *
     * @return array $this->validCharacters
     */
    final protected function getValidCharacters()
    {
        if (!isset($this->validCharacters)) {
            $this->validCharacters = array_merge(
                // + and /.
                array('+', '/'),
                // 0-9.
                array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
                // A-Z.
                range('A', 'Z'),
                // a-z.
                range('a', 'z'),
                $this->allowCRLF
                    ? array("\r", "\n")
                    : array()
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
    protected function validateMessage($message)
    {
        // Base64 is encoded in a string.
        if (!is_string($message)) {
            return false;
        }

        // If the padding should be validated, do so now.
        if ($this->validatePadding && !$this->validatePadding($message)) {
            return false;
        }

        // The padding characters may only be to the right of the string.
        $message = rtrim($message, $this::PADDING);
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
     * Validate the padding of a given message.
     *
     * @param string
     * @return boolean
     */
    final protected function validatePadding($message)
    {
        $length = strlen($message);

        // The message should always be a multitude of 4 if padding is applied.
        if (($length % 4) !== 0) {
            return false;
        }

        $trimmedLength = strlen(
            // Base64 only has a padding on the right side of the string.
            // That is why we use rtrim to only trim off on the right side.
            rtrim($message, $this::PADDING)
        );

        // The padding should be either 0, 1 or 2 characters long.
        if (($length - $trimmedLength) > 2) {
            return false;
        }

        // All rules are satisfied.
        return true;
    }
}
