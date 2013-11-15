<?php
/**
 * A data container.
 *
 * @package HylianShield
 * @subpackage data
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield;

use \InvalidArgumentException;
use \LogicException;
use \UnexpectedValueException;
use \HylianShield\Validator\CoreArray;
use \HylianShield\Validator\String;
use \HylianShield\Validator\CoreClass;
use \HylianShield\Validator\CoreClass\Method;

/**
 * ArrayObject.
 */
class ArrayObject extends \ArrayObject
{
    /**
     * The serializer to use when serializing the data.
     *
     * @var string $serializer
     */
    protected $serializer = '\HylianShield\Serializer\Php';

    /**
     * Whether the data is dirty.
     *
     * @var boolean $dirty
     */
    protected $dirty = false;

    /**
     * Tell if the data is dirty and should be saved when possible.
     *
     * @return boolean
     */
    public function isDirty()
    {
        return $this->dirty;
    }

    /**
     * Forbid appending to this data.
     *
     * @return void
     * @throws \LogicException
     */
    public function append($value)
    {
        throw new LogicException(
            'Cannot append to a data object. Specific key=>value pairs are required!'
        );
    }

    /**
     * Set a given property.
     *
     * @param mixed $index
     * @param mixed $value
     */
    public function offsetSet($index, $value)
    {
        $oldValue = $this->offsetExists($index)
            ? $this->offsetGet($index)
            : null;

        parent::offsetSet($index, $value);

        if ($oldValue !== $value) {
            $this->dirty = true;
        }
    }

    /**
     * Unset a given property.
     *
     * @param mixed $index
     */
    public function offsetUnset($index)
    {
        parent::offsetUnset($index);
        $this->dirty = true;
    }

    /**
     * Set the serializer.
     *
     * @param string $serializer
     * @throws \InvalidArgumentException when the given serializer is not a string
     * @throws \LogicException when the given serializer class does not exist
     * @throws \LogicException when the supplied serializer lacks specific methods
     */
    public function setSerializer($serializer)
    {
        $class = new CoreClass;

        if (!$class($serializer)) {
            throw new LogicException(
                "Supplied serializer class could not be found: {$serializer}"
            );
        }

        $required = array('serialize', 'unserialize');
        $methodExists = new Method($serializer);

        foreach ($required as $method) {
            if (!$methodExists($method)) {
                // Gather debugging information.
                $existingMethods = get_class_methods($serializer);
                $intersection = array_intersect($required, $existingMethods);
                $diff = array_diff($required, $intersection);

                throw new LogicException(
                    "The supplied serializer {$serializer} is missing the "
                    . 'following methods: ' . implode(', ', $diff)
                );
            }
        }

        $this->serializer = $serializer;
    }

    /**
     * Return the serialized representation of the data.
     *
     * @return string
     */
    public function serialize()
    {
        return (string) call_user_func_array(
            "{$this->serializer}::serialize",
            array($this->getArrayCopy())
        );
    }

    /**
     * Import a serialized data and make it our own.
     * Note: this overrides our current data.
     *
     * @param string $serialized
     * @return void
     * @throws \InvalidArgumentException when $serialized is not a string
     * @throws \UnexpectedValueException when the unserialized data does not appear
     *   to be an array
     */
    public function unserialize($serialized)
    {
        $string = new String;

        if (!$string($serialized)) {
            throw new InvalidArgumentException(
                'Supplied data is not a serialized string: (' . gettype($serialized)
                . ') ' . var_export($serialized, true)
            );
        }

        // Conditionally update the dirty flag afterwards.
        // We don't believe the data to have become dirty if there
        // was no data to begin with.
        $dirty = $this->dirty || $this->count() > 0;

        $data = call_user_func_array(
            "{$this->serializer}::unserialize",
            array($serialized)
        );

        $array = new CoreArray;

        if (!$array($data)) {
            throw new UnexpectedValueException(
                'Unserialized data is not a valid array. Tried unserializing "'
                . "{$serialized}\" and came back with: (" . gettype($data) . ') '
                . var_export($data, true)
            );
        }

        // Update the data.
        $this->exchangeArray($data);

        // Set the dirty flag.
        $this->dirty = $dirty;
    }

    /**
     * Convert the data to a string.
     *
     * @return string
     */
    public function __tostring()
    {
        return $this->serialize();
    }
}
