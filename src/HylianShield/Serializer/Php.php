<?php
/**
 * A PHP serializer.
 *
 * @package HylianShield
 * @subpackage Serializer
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Serializer;

/**
 * Php.
 */
class Php extends \HylianShield\Serializer
{
    /**
     * Serialize the given data.
     *
     * @param mixed $data
     * @return string
     */
    public function serialize($data)
    {
        return serialize($data);
    }

    /**
     * Unserialize the given data.
     *
     * @param string $serialized
     * @return mixed
     */
    public function unserialize($serialized)
    {
        return unserialize($serialized);
    }
}
