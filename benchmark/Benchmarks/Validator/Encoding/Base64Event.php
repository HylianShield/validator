<?php
/**
 * Benchmark for Validator\Encoding\Base64.
 *
 * @package HylianShield
 * @subpackage Benchmarks
 */

namespace Benchmarks\Validator\Encoding;

use \AthLetic\AthleticEvent;
use \HylianShield\Validator\Encoding\Base64;

/**
 * Base64Event.
 */
class Base64Event extends AthleticEvent
{
    /**
     * The Base64 alphabet.
     *
     * @var string ÀLPHABET
     */
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

    /**
     * The valid pattern.
     *
     * @var string PATTERN
     */
    const PATTERN = '/^[^A-Za-z0-9\+\/]+$/';

    /**
     * A list of valid characters.
     *
     * @var array $validCharacters
     * @see http://tools.ietf.org/html/rfc4648#section-4
     */
    private $validCharacters;

    /**
     * The string to benchmark against.
     *
     * @var string $test
     */
    protected $test = 'I am a very small string that will be properly encoded on setUp';

    /**
     * The listPattern.
     *
     * @var string $listPattern
     */
    private $listPattern;

    /**
     * The alphabetPattern.
     *
     * @var string $alphabetPattern
     */
    private $alphabetPattern;

    /**
     * Create the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        $this->test = base64_encode($this->test);
        $this->getListPattern();
        $this->getAlphabetPattern();
    }

    /**
     * Setter for alphabetPattern.
     *
     * @param string $alphabetPattern
     * @return void
     * @throws \InvalidArgumentException when alphabetPattern is invalid.
     */
    public function setAlphabetPattern($alphabetPattern)
    {
        if (!is_string($alphabetPattern)) {
            throw new InvalidArgumentException('Invalid alphabetPattern supplied');
        }

        $this->alphabetPattern = $alphabetPattern;
    }

    /**
     * Getter for alphabetPattern.
     *
     * @return string $alphabetPattern
     */
    public function getAlphabetPattern()
    {
        if (!isset($this->alphabetPattern)) {
            $this->alphabetPattern = '/^[^' . preg_quote($this::ALPHABET, '/') . ']+$/';
        }

        return $this->alphabetPattern;
    }

    /**
     * Setter for listPattern.
     *
     * @param string $listPattern
     * @return void
     * @throws \InvalidArgumentException when listPattern is invalid.
     */
    public function setListPattern($listPattern)
    {
        if (!is_string($listPattern)) {
            throw new InvalidArgumentException('Invalid listPattern supplied');
        }

        $this->listPattern = $listPattern;
    }

    /**
     * Getter for listPattern.
     *
     * @return string $listPattern
     */
    public function getListPattern()
    {
        if (!isset($this->listPattern)) {
            $this->listPattern = '/^[^' . preg_quote(implode('', $this->getValidCharacters()), '/') . ']+$/';
        }

        return $this->listPattern;
    }

    /**
     * Setter for validCharacters.
     *
     * @param array $validCharacters
     * @return void
     */
    protected function setValidCharacters(array $validCharacters)
    {
        $this->validCharacters = $validCharacters;
    }

    /**
     * Get a list of valid characters. Does the setup if the list is absent.
     *
     * @return array $this->validCharacters
     * @see http://tools.ietf.org/html/rfc4648#section-4
     */
    protected function getValidCharacters()
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
     * Validate the encoded string with an in_array check.
     *
     * @iterations 25
     */
    public function inArrayValidation()
    {
        $test = $this->test;
        $length = strlen($test);
        $validCharacters = $this->getValidCharacters();

        for ($c = 0; $c < $length; $c++) {
            if (!in_array($test[$c], $validCharacters, true)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate the encoded string with a preg_match using the complete alphabet from an array.
     *
     * @iterations 25
     */
    public function pregMatchList()
    {
        $test = $this->test;
        $pattern = $this->getListPattern();

        if (preg_match($pattern, $test)) {
            return false;
        }

        return true;
    }

    /**
     * Validate the encoded string with a preg_match using the complete alphabet.
     *
     * @iterations 25
     */
    public function pregMatchAlphabet()
    {
        $test = $this->test;
        $pattern = $this->getAlphabetPattern();

        if (preg_match($pattern, $test)) {
            return false;
        }

        return true;
    }

    /**
     * Validate the encoded string with a preg_match using a pre-built pattern.
     *
     * @iterations 25
     */
    public function pregMatchPattern()
    {
        $test = $this->test;
        $pattern = $this::PATTERN;

        if (preg_match($pattern, $test)) {
            return false;
        }

        return true;
    }
}
