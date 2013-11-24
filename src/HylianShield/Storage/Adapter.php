<?php
/**
 * A storage adapter for HylianShield configurations.
 *
 * @package HylianShield
 * @subpackage Storage
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Storage;

use \InvalidArgumentException;
use \RuntimeException;
use \UnexpectedValueException;
use \HylianShield\Validator\String;

/**
 * Adapter.
 */
abstract class Adapter
{
    /**
     * Get data from the storage adapter and return it to the application.
     *
     * @return string
     * @throws \RuntimeException when the storage could not be accessed
     * @throws \UnexpectedValueException when the storage delivered data of the wrong type
     */
    final public function get()
    {
        if (!$this->pingRead()) {
            throw new RuntimeException(
                'Cannot read from storage adapter with: '
                . var_export($this->settings(), true)
            );
        }

        // Read from the adapter.
        $rv = $this->read();

        // Check if the return value delivers the expected result.
        $string = new String;
        if (!$string($rv)) {
            throw new UnexpectedValueException(
                'The storage gave back an unexpected value: (' . gettype($rv)
                . ') ' . var_export($rv, true)
            );
        }

        return $rv;
    }

    /**
     * Store the supplied data in the storage.
     *
     * @param string $data
     * @return void
     * @throws \InvalidArgumentException when anything but a string is supplied
     * @throws \RuntimeException when storing the data failed
     */
    final public function store($data)
    {
        $string = new String;

        if (!$string($data)) {
            throw new InvalidArgumentException(
                'Only strings can stored: (' . gettype($data) . ') '
                . var_export($data, true)
            );
        }

        if (!$this->pingWrite()) {
            throw new RuntimeException(
                'Cannot write to storage adapter with: '
                . var_export($this->settings(), true)
            );
        }

        $this->write($data);
    }

    /**
     * Return with an array of settings used to get the storage adapter working.
     *
     * @return array.
     */
    public abstract function settings();

    /**
     * Store data in the storage. It is expected that it is somehow ensured that
     * this data will be saved one way or the other.
     *
     * E.g. the adapter can decide that on desctruct it writes to a database.
     * However, it is suggested the adapter does this at once, since the application
     * will specifically call store.
     *
     * @param string $data
     * @return void
     */
    protected abstract function write($data);

    /**
     * Get data from the storage.
     *
     * @return string $data
     */
    protected abstract function read();

    /**
     * Tell if the read actions are still an option.
     * This can be an open database connection or checking if a file is readable.
     *
     * @return bool
     */
    public abstract function pingRead();

    /**
     * Tell if the write actions are still an option.
     * This can be an open database connection or checking if a file is writable.
     *
     * @return bool
     */
    public abstract function pingWrite();
}
