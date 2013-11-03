<?php
/**
 * Serializer for JSON, optimized for configuration files.
 *
 * @package HylianShield
 * @subpackage Serializer
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Serializer;

/**
 * JsonConf.
 */
class JsonConf
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
     * @return string|false
     */
    public static function serialize($data)
    {
        return json_encode(
            $data,
            // Encode to a minimalistic representation that stays editable by hand.
            // Pretty printing ensures we have a line for each propery-value pair.
            JSON_PRETTY_PRINT
            // Unescaped slashes ensures that we can actually read URLs and the likes.
            | JSON_UNESCAPED_SLASHES
            // Unescaped Unicode ensures we can read UTF-8 characters in our editors.
            | JSON_UNESCAPED_UNICODE
            // The numeric check converts numeric values to a numeric representation.
            | JSON_NUMERIC_CHECK
        );
    }

    /**
     * Unserialize the given JSON.
     *
     * @param string $json
     * @return mixed
     */
    public static function unserialize($json)
    {
        return json_decode($json, true, self::MAXDEPTH);
    }
}
