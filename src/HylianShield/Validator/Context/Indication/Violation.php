<?php
/**
 * A constraint violation of a validation process.
 *
 * @package HylianShield
 * @subpackage Validator
 */
namespace HylianShield\Validator\Context\Indication;

use \InvalidArgumentException;
use \LogicException;

/**
 * A constraint violation of a validation process.
 */
class Violation extends IndicationAbstract implements ViolationInterface
{
    /**
     * The violation code.
     *
     * @var integer $code
     */
    protected $code;

    /**
     * A list of violation context parameters and their values.
     *
     * @var array $context
     */
    protected $context;

    /**
     * Initialize a new constraint violation.
     *
     * @param string $description
     * @param integer $code
     * @param array $context
     */
    public function __construct($description, $code, array $context = array())
    {
        $this->setDescription($description);
        $this->setCode($code);
        $this->setContext($context);
    }

    /**
     * Set the code of the violation.
     *
     * @param integer $code
     * @return Violation
     * @throws \InvalidArgumentException when $code is not an integer.
     */
    protected function setCode($code)
    {
        if (!is_integer($code)) {
            throw new InvalidArgumentException(
                'Invalid code supplied: ' . gettype($code)
            );
        }

        $this->code = $code;

        return $this;
    }

    /**
     * Get the violation code.
     *
     * @return integer
     * @throws \LogicException when code is not set.
     */
    public function getCode()
    {
        if (!isset($this->code)) {
            throw new \LogicException(
                'Missing property code.'
            );
        }

        return $this->code;
    }

    /**
     * Setter for context.
     *
     * @param array $context
     * @return Violation
     */
    protected function setContext(array $context = array())
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get the context parameters of the violation.
     *
     * @return array
     * @throws \LogicException when the context property is not set.
     */
    public function getContext()
    {
        if (!isset($this->context)) {
            throw new LogicException(
                'Missing property context.'
            );
        }

        return $this->context;
    }

    /**
     * Interpolate the context parameters into the supplied local translation
     * of the violation.
     * The given string can use :param to denote the position where the
     * parameters can be interpolated.
     * E.g.:
     * Context: ['user' => 'Impa', 'domain' => 'gerudo.vil.hyr']
     * Translation: Invalid user :user and domain :domain found.
     * Interpolated: Invalid user Impa and domain gerudo.vil.hyr found.
     *
     * @param string $translation
     * @param string $interpolationStart
     * @param string $interpolationEnd
     * @return string
     * @throws \InvalidArgumentException when $translation is not a string
     * @throws \InvalidArgumentException when $interpolationStart is not a
     *   string
     * @throws \InvalidArgumentException when $interpolationEnd is not a string
     */
    public function interpolate(
        $translation,
        $interpolationStart = ':',
        $interpolationEnd = ''
    ) {
        if (!is_string($translation)) {
            throw new InvalidArgumentException(
                'Invalid translation type supplied: ' . gettype($translation)
            );
        }

        if (!is_string($interpolationStart)) {
            throw new InvalidArgumentException(
                'Invalid interpolationStart type supplied: '
                . gettype($interpolationStart)
            );
        }

        if (!is_string($interpolationEnd)) {
            throw new InvalidArgumentException(
                'Invalid interpolationEnd type supplied: '
                . gettype($interpolationEnd)
            );
        }

        $context = $this->getContext();

        // Return an interpolated translation string.
        return str_replace(
            // Search for these entries.
            array_map(
                // Generate interpolation identifiers.
                function ($key) use ($interpolationStart, $interpolationEnd) {
                    return "{$interpolationStart}{$key}{$interpolationEnd}";
                },
                array_keys($context)
            ),
            // Replace with these entries.
            array_values($context),
            // Use this as input.
            $translation
        );
    }
}
