<?php
/**
 * Configuration.
 *
 * @package HylianShield
 * @subpackage Configuration
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield;

use \ArrayObject;
use \InvalidArgumentException;
use \LogicException;
use \RuntimeException;
use \UnexpextedValueException;

/**
 * Configuration.
 */
class Configuration extends ArrayObject
{
    /**
     * The serializer to use when serializing the configuration.
     *
     * @var string $serializer
     */
    protected $serializer = '\HylianShield\Serializer\Php';

    /**
     * The file in which the configuration is stored.
     *
     * @var string $storageFile
     */
    protected $storageFile;

    /**
     * Whether the configuration is dirty.
     *
     * @var boolean $dirty
     */
    protected $dirty = false;

    /**
     * A set of validators, keyed by the data type it should validate.
     *
     * @var array $validators
     */
    protected $validators = array();

    /**
     * A list of validation rules, keyed by the property it should validate.
     *
     * @var array $validationRules
     */
    protected $validationRules = array();

    /**
     * Keys that must be present in the configuration.
     *
     * @var array $required
     */
    protected $required = array();

    /**
     * Tell if the configuration is dirty and should be saved when possible.
     *
     * @return boolean
     */
    public function isDirty()
    {
        return $this->dirty;
    }

    /**
     * Set a validator.
     *
     * @param \HylianShield\ValidatorAbstract $validator
     * @param string $type
     * @return void
     * @throws \InvalidArgumentException when $type is not a string
     */
    public function setValidator(\HylianShield\ValidatorAbstract $validator, $type = null)
    {
        if ($type !== null && !is_string($type)) {
            throw new InvalidArgumentException(
                'Supplied type is not a string: (' . gettype($type) . ') '
                . var_export($type, true)
            );
        }

        $this->validators[isset($type) ? $type : $validator->type()] = $validator;
    }

    /**
     * Set or flush the validation rules for a given property.
     *
     * @param string $property
     * @param array $rules
     * @return void
     * @throws \InvalidArgumentException when $property is not a string
     * @throws \InvalidArgumentException when a rule is not a string
     * @throws \LogicException when there is no validator for a supplied rule
     */
    public function setValidationRules($property, array $rules = array())
    {
        if (!is_string($property)) {
            throw new InvalidArgumentException(
                'Supplied property is not a string: (' . gettype($property)
                . ') ' . var_export($property, true)
            );
        }

        $validators = array_keys($this->validators);

        // Check all supplied rules.
        array_walk(
            $rules,
            function ($rule) use ($validators) {
                if (!is_string($rule)) {
                    throw new InvalidArgumentException(
                        'Supplied rule is not a string: (' . gettype($rule)
                . ') ' . var_export($rule, true)
                    );
                }

                if (!in_array($rule, $validators, true)) {
                    throw new LogicException(
                        'Supplied rule has no corresponding validator set. '
                        . 'Expected one of: ' . json_encode($validators) . ', '
                        . "yet the supplied rule was: {$rule}"
                    );
                }
            }
        );

        unset($validators);
        $validators =& $this->validators;

        // Map the validators to the validation rules.
        $this->validationRules[$property] = array_map(
            function ($rule) use ($validators) {
                return $validators[$rule];
            },
            $rules
        );
    }

    /**
     * Validate the rules.
     *
     * @param boolean $returnFailedProperties
     * @return boolean|array
     */
    public function validate($returnFailedProperties = false)
    {
        $valid = true;
        $failedProperties = array();

        // Check if all required properties are present.
        if (!empty($this->required)) {
            foreach ($this->required as $property) {
                if (!isset($this[$property])) {
                    $valid = false;

                    if (!$returnFailedProperties) {
                        break;
                    }

                    // Tell the property failed because it was required.
                    $failedProperties[$property] = array(
                        'value' => null,
                        'failed' => array('required')
                    );
                }
            }
        }

        // Check all validation rules.
        foreach ($this->validationRules as $property => $validators) {
            // Skip properties that aren't set.
            if (!isset($this[$property])) {
                continue;
            }

            $value = $this[$property];

            // Walk through all validators and map the failed ones.
            $fails = array_filter(
                $validators,
                function ($validator) use ($value) {
                    return $validator($value) !== true;
                }
            );

            // If validators failed, set the validation to false.
            if (count($fails)) {
                $valid = false;

                // If we want to return the failed properties, map them and
                // continue.
                if ($returnFailedProperties) {
                    $failedProperties[$property] = array(
                        'value' => '(' . gettype($value) . ') ' . var_export($value, true),
                        'failed' => array_map(
                            function ($validator) {
                                return "{$validator}";
                            },
                            $fails
                        )
                    );
                    continue;
                }

                // Break off as there is no futher need to check the rest.
                break;
            }
        }

        unset($value);

        // If we failed and want to return the failed properties, do just that.
        // Otherwise, simply return a boolean.
        return !$valid && $returnFailedProperties ? $failedProperties : $valid;
    }

    /**
     * Store the current configuration in it's storageFile.
     *
     * @return void
     * @throws \RuntimeException when the validators don't validate all properties
     * @throws \LogicException when $this->storageFile is not set
     * @throws \RuntimeException when $this->storageFile is not writable
     * @throws \UnexpectedValueException when the encoded configuration becomes empty
     * @throws \RuntimeException when writing to the file failed
     */
    public function store()
    {
        $validation = $this->validate(true);

        if ($validation !== true) {
            throw new RuntimeException(
                'Could not validate all properties. The following validations failed: '
                . json_encode($validation, JSON_PRETTY_PRINT)
            );
        }

        if (!isset($this->storageFile)) {
            throw new LogicException(
                'Tried to store the configuration, but no storage file set.'
            );
        }

        if (!is_writable($this->storageFile)) {
            throw new RuntimeException(
                "Current configuration is not writable: {$this->storageFile}"
            );
        }

        if ($this->count() === 0) {
            throw new RuntimeException(
                'Configuration was completely empty.'
                . 'If you want to flush your configuration, please use Configuration::flush()'
            );
        }

        $encodedConfig = $this->serialize();

        if (empty($encodedConfig)) {
            throw new UnexpextedValueException(
                'Could not properly encode the following: '
                . var_export($this->getArrayCopy(), true)
            );
        }

        // Store the configuration with an exclusive lock on the file and get the
        // amount of bytes stored.
        $bytes = file_put_contents($this->storageFile, $encodedConfig, LOCK_EX);

        // Writing failed or was only partially done.
        if (empty($bytes) || $bytes < strlen($encodedConfig)) {
            throw new RuntimeException(
                "Failed writing configuration to: {$this->storageFile}"
            );
        }

        $this->dirty = false;
    }

    /**
     * Flush the current configuration AND it's storage file if that is set.
     *
     * @return void
     */
    public function flush()
    {
        $this->exchangeArray(array());

        if (isset($this->storageFile)) {
            file_put_contents($this->storageFile, '', LOCK_EX);
        }

        $this->dirty = false;
    }

    /**
     * Set the path to the storage file.
     *
     * @param string $file
     * @return void
     * @throws \InvalidArgumentException when $file is not a file path
     * @throws \RuntimeException when $file is not writable
     */
    public function setStorage($file)
    {
        if (!is_string($file) || !file_exists($file)) {
            throw new InvalidArgumentException(
                'Invalid configuration file supplied: (' . gettype($file)
                . ') ' . var_export($file, true)
            );
        }

        if (!is_writable($file)) {
            throw new RuntimeException(
                "The configuration file is not writable: {$file}"
            );
        }

        $this->storageFile = $file;
    }

    /**
     * Load the configuration from our storage file.
     *
     * @return void
     * @throws \LogicException when the storage file is not set
     */
    public function loadStorage()
    {
        if (!isset($this->storageFile)) {
            throw new LogicException(
                'Cannot load from storage when no storage file is set.'
            );
        }

        $this->unserialize(@trim(file_get_contents($this->storageFile)));
    }

    /**
     * Forbid appending to this configuration.
     *
     * @return void
     * @throws \LogicException
     */
    public function append($value)
    {
        throw new LogicException(
            'Cannot append to a configuration object. Specific key=>value pairs are required!'
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
        $oldValue = $this->offsetExists($index) ? $this->offsetGet($index) : null;

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
        if (!is_string($serializer)) {
            throw new InvalidArgumentException(
                'Invalid serializer supplied: (' . gettype($serializer) . ') '
                . var_export($serializer)
            );
        }

        if (!class_exists($serializer, true)) {
            throw new LogicException(
                "Supplied serializer class could not be found: {$serializer}"
            );
        }

        $required = array('serialize', 'unserialize');

        foreach ($required as $method) {
            if (!method_exists($serializer, $method)) {
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
     * Return the serialized representation of the configuration.
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
     * Import a serialized configuration and make it our own.
     * Note: this overrides our current configuration.
     *
     * @param string $serialized
     * @return void
     */
    public function unserialize($serialized)
    {
        // Conditionally update the dirty flag afterwards.
        // We don't believe the configuration to have become dirty if there
        // was no configuration to begin with.
        $dirty = $this->dirty || $this->count() > 0;

        // Update the configuration.
        $this->exchangeArray(
            call_user_func_array(
                "{$this->serializer}::unserialize",
                array($serialized)
            )
        );

        // Set the dirty flag.
        $this->dirty = $dirty;
    }

    /**
     * Convert the configuration to a string.
     *
     * @return string
     */
    public function __tostring()
    {
        return $this->serialize();
    }

    /**
     * Make sure the configuration gets stored.
     *
     *
     */
    public function __destruct()
    {
        if (isset($this->storageFile)) {
            $this->store();
        }
    }
}
