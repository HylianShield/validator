<?php
/**
 * File storage adapter.
 *
 * @package HylianShield
 * @subpackage Storage
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Storage\Adapter;

use \InvalidArgumentException;
use \RuntimeException;
use \HylianShield\Validator\Integer;
use \HylianShield\Validator\LogicalAnd;
use \HylianShield\Validator\String;
use \HylianShield\Validator\File\Exists;
use \HylianShield\Validator\File\Readable;
use \HylianShield\Validator\File\Writable;

/**
 * File.
 */
class File extends \HylianShield\Storage\Adapter
{
    /**
     * A set of storage flags.
     *
     * @var integer $storageFlags
     */
    private $storageFlags = LOCK_EX;

    /**
     * A list of valid storage flags and combinations.
     * Essentially this is a list of valid bitmasks.
     *
     * We excplicitly exclude FILE_USE_INCLUDE_PATH from the list of valid flags.
     * This is because the adapter will resolve the absolute path of the file.
     *
     * @var array $validStorageFlags
     */
    protected $validStorageFlags = array(
        0,
        FILE_APPEND,
        LOCK_EX
    );

    /**
     * The file in which we store the supplied data.
     *
     * @var string $storageFile
     */
    private $storageFile;

    /**
     * The constructor for File.
     *
     * @param string $path path to storage file
     * @param integer $flags the bitmask value of file flags
     * @see http://php.net/manual/en/function.file-put-contents.php
     * @throws \InvalidArgumentException when the supplied file is not readable or writable
     * @throws \InvalidArgumentException when the supplied flags are not within the valid range
     */
    public function __construct($path, $flags = LOCK_EX)
    {
        // Set up a validator for the supplied path.
        $valid = new LogicalAnd(
            new String,
            new Exists,
            new Readable,
            new Writable
        );

        // Check if the path is valid.
        if (!$valid($path)) {
            throw new InvalidArgumentException(
                'Supplied path is not a valid readable and writable file: ('
                . gettype($path) . ') ' . var_export($path, true)
            );
        }

        $integer = new Integer;

        // The combination of storage flags is a valid option.
        $this->validStorageFlags[] = array_sum($this->validStorageFlags);

        if (!$integer($flags) || !in_array($flags, $this->validStorageFlags)) {
            throw new InvalidArgumentException(
                'Supplied flags are invalid. Expected one of: '
                . var_export($this->validStorageFlags, true) . '; Yet supplied: ('
                . gettype($flags) .') ' . var_export($flags, true)
            );
        }

        $this->storageFile = realpath($path);
        $this->storageFlags = $flags;
    }

    /**
     * Tell what settings we currently use for our adapter.
     *
     * @return array
     */
    final public function settings()
    {
        return array(
            'file' => $this->storageFile,
            'flags' => $this->storageFlags
        );
    }

    /**
     * Tell if the storage file is readable.
     *
     * @return bool
     */
    final public function pingRead()
    {
        $readable = new Readable;
        return $readable($this->storageFile);
    }

    /**
     * Get data from storage.
     *
     * @return string
     * @throws \RuntimeException when the data could not be accessed
     */
    final protected function read()
    {
        // Retrieve the contents of the storage file.
        // We suppres errors, since the adapter should be able to take care of
        // unexpected results.
        $rv = @file_get_contents($this->storageFile);

        if ($rv === false) {
            throw new RuntimeException(
                "Could not access data in file {$this->storageFile}."
            );
        }

        return $rv;
    }

    /**
     * Tell if the storage file is writable.
     *
     * @return bool
     */
    final public function pingWrite()
    {
        $writable = new Writable;
        return $writable($this->storageFile);
    }

    /**
     * Store supplied data in the storage file.
     *
     * @param string $data
     * @throws \RuntimeException when the data could not be stored (whole)
     */
    final protected function write($data)
    {
        $bytesIn = strlen($data);
        $bytesStored = @file_put_contents(
            $this->storageFile,
            $data,
            $this->storageFlags
        );

        if ($bytesStored !== $bytesIn) {
            // Make sure we have a numeric value for $bytesStored.
            // It can be false when an error occured and we don't want to forbid
            // storing empty strings in a file, so we cast it over here, instead
            // of directly when file_put_contents returns it to us.
            $bytesStored += 0;

            throw new RuntimeException(
                "Could not store data in file {$this->storageFile}. Expected {$bytesIn}"
                . " bytes to be written to the file. A total of {$bytesStored} bytes got"
                . " stored away. Please check if the file is writable and the application"
                . " has an exclusive lock on the file."
            );
        }
    }
}
