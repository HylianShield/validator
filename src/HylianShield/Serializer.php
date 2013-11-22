<?php
/**
 * HylianShield Serializer abstract.
 *
 * @package HylianShield
 * @subpackage Serializer
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield;

/**
 * Serializer.
 */
abstract class Serializer
{
    /**
     * Serialize the given data.
     *
     * @param mixed $data
     * @return string
     */
    abstract public function serialize($data);

    /**
     * Unserialize the given data.
     *
     * @param string $serialized
     * @return mixed
     */
    abstract public function unserialize($serialized);

    /**
     * Serialize the given data. A wrapper around serialize.
     *
     * @param mixed $data
     * @return string
     */
    final public function __invoke($data) {
        return $this->serialize($data);
    }
}
