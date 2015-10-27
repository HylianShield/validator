<?php
/**
 * A URL parser based on a supplied callback function.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Parser;

/**
 * A URL parser based on a supplied callback function.
 */
class CallbackParser extends ParserAbstract
{
    /**
     * The callback to apply when parsing data.
     *
     * @var \Closure $callback
     */
    private $callback;

    /**
     * Initialize a new callback parser.
     *
     * @param \Closure $callback
     */
    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Forward parser logic to the concrete implementation.
     *
     * @param mixed $url
     * @return array
     */
    protected function applyParser($url)
    {
        return call_user_func($this->callback, $url);
    }
}
