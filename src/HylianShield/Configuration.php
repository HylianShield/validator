<?php
/**
 * Configuration.
 *
 * @package HylianShield
 * @subpackage Configuration
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield;

use \InvalidArgumentException;
use \LogicException;
use \RuntimeException;
use \UnexpextedValueException;

/**
 * Configuration.
 */
class Configuration extends \HylianShield\ArrayObject
{
    /**
     * The storage in which the configuration is stored.
     *
     * @var \HylianShield\Storage\Adapter $storage
     */
    protected $storage;

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

        if (!isset($this->storage)) {
            throw new LogicException(
                'Tried to store the configuration, but no storage was set.'
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
            throw new UnexpectedValueException(
                'Could not properly encode the following: '
                . var_export($this->getArrayCopy(), true)
            );
        }

        $this->storage->store($encodedConfig);

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
     * Set the storage adapter.
     *
     * @param \HylianShield\Storage\Adapter $adapter
     * @return void
     */
    public function setStorage(\HylianShield\Storage\Adapter $adapter)
    {
        $this->storage = $adapter;
    }

    /**
     * Load the configuration from our storage file.
     *
     * @return void
     * @throws \LogicException when the storage file is not set
     */
    public function loadStorage()
    {
        if (!isset($this->storage)) {
            throw new LogicException(
                'Cannot load from storage when no storage is set.'
            );
        }

        $this->unserialize(trim($this->storage->get()));
    }

    /**
     * Make sure the configuration gets stored.
     *
     *
     */
    public function __destruct()
    {
        if (isset($this->storage)) {
            $this->store();
        }
    }
}
