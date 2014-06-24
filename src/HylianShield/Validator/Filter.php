<?php
/**
 * Abstract layer to couple the internal filter_var logic with the HylianShield validator.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

use \LogicException;

/**
 * Filter abstraction.
 * Abstract layer to couple the internal filter_var logic with the HylianShield validator.
 * @see http://php.net/manual/en/function.filter-var.php
 */
abstract class Filter extends \HylianShield\Validator
{
    /**
     * The filter to apply to the filter_var function.
     *
     * @var integer FILTER
     */
    const FILTER = 0;

    /**
     * Options for the filter, if it accepts any.
     *
     * @var array $options
     * @see http://php.net/manual/en/function.filter-var.php#refsect1-function.filter-var-parameters
     * @see http://php.net/manual/en/filter.filters.validate.php
     */
    protected static $options = array(
        'default' => false
    );

    /**
     * Flags for the filter, if it accepts any.
     *
     * @var integer $flags
     * @see http://php.net/manual/en/function.filter-var.php#refsect1-function.filter-var-parameters
     * @see http://php.net/manual/en/filter.filters.validate.php
     */
    protected static $flags = 0;

    /**
     * The constructor for Filter.
     *
     * @throws \LogicException when $this::FILTER is not an integer or no more than zero.
     */
    final public function __construct()
    {
        $filter = $this::FILTER;

        if (!is_integer($filter) || $filter <= 0) {
            // @codeCoverageIgnoreStart
            throw new LogicException('Invalid filter configured!');
            // @codeCoverageIgnoreEnd
        }

        $this->validator = array($this, 'filterVar');
    }

    /**
     * Filter the given var using the $this::FILTER constant.
     *
     * @param mixed $var
     * @return boolean
     */
    protected function filterVar($var)
    {
        return filter_var(
            $var,
            $this::FILTER,
            array(
                'options' => $this::$options,
                'flags' => $this::$flags
            )
        );
    }
}
