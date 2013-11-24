<?php
/**
 * Serializer for JSON, optimized for configuration files.
 *
 * @package HylianShield
 * @subpackage Serializer
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Serializer;

use \LogicException;
use \RuntimeException;
use \HylianShield\Validator\CoreFunction;
use \HylianShield\Validator\String;

/**
 * JsonConf.
 */
class JsonConf extends \HylianShield\Serializer
{
    /**
     * The maximum depth of the configuration structure.
     *
     * @const integer MAXDEPTH
     */
    const MAXDEPTH = 8;

    /**
     * Serialize the given data.
     *
     * @param mixed $data
     * @return string $rv
     * @throws \LogicException when function json_encode does not exist
     * @throws \RuntimeException when serializing failed
     */
    public function serialize($data)
    {
        $function = new CoreFunction;

        // Recent PHP packages for specific vendors have stopped shipping with
        // this core functionality because of a license dispute between JSON and PHP.
        if (!$function('json_encode')) {
            // @codeCoverageIgnoreStart
            throw new LogicException('Missing function json_encode');
            // @codeCoverageIgnoreEnd
        }

        $options = 0;

        // The numeric check converts numeric values to a numeric representation.
        // Available for PHP >= 5.3.3
        if (defined('JSON_NUMERIC_CHECK')) {
            $options += JSON_NUMERIC_CHECK;
        }

        // Encode to a minimalistic representation that stays editable by hand.
        // Pretty printing ensures we have a line for each property=>value pair.
        // Available for PHP >= 5.4.0
        if (defined('JSON_PRETTY_PRINT')) {
            $options += JSON_PRETTY_PRINT;
        }

        // Unescaped slashes ensures that we can actually read URLs and the likes.
        // Available for PHP >= 5.4.0
        if (defined('JSON_UNESCAPED_SLASHES')) {
            $options += JSON_UNESCAPED_SLASHES;
        }

        // Unescaped Unicode ensures we can read UTF-8 characters in our editors.
        // Available for PHP >= 5.4.0
        if (defined('JSON_UNESCAPED_UNICODE')) {
            $options += JSON_UNESCAPED_UNICODE;
        }

        $rv = @json_encode($data, $options);

        $string = new String;

        if ($rv === false || !$string($rv)) {
            $message = 'JSON encoding error #' . json_last_error();

            // Available for PHP >= 5.5.
            if ($function('json_last_error_msg')) {
                $message .= "\n" . json_last_error_msg();
            }

            $message .= "\n Could not properly encode supplied data: ("
                . gettype($data) . ') ' . var_export($data, true);

            throw new RuntimeException($message);
        }

        return $rv;
    }

    /**
     * Unserialize the given JSON.
     *
     * @param string $json
     * @return mixed $rv
     * @throws \LogicException when function json_decode does not exist
     * @throws \RuntimeException when unserializing the JSON failed
     */
    public function unserialize($json)
    {
        $function = new CoreFunction;

        // Recent PHP packages for specific vendors have stopped shipping with
        // this core functionality because of a license dispute between JSON and PHP.
        if (!$function('json_decode')) {
            // @codeCoverageIgnoreStart
            throw new LogicException('Missing function json_decode');
            // @codeCoverageIgnoreEnd
        }

        $rv = json_decode($json, true, self::MAXDEPTH);

        $error = json_last_error();

        if ($error !== JSON_ERROR_NONE) {
            $message = "JSON decoding error #{$error}";

            // Available for PHP >= 5.5.
            if ($function('json_last_error_msg')) {
                $message .= "\n" . json_last_error_msg();
            }

            $message .= "\n Could not properly decode supplied data: ("
                . gettype($json) . ') ' . var_export($json, true);

            throw new RuntimeException($message);
        }

        return $rv;
    }
}
