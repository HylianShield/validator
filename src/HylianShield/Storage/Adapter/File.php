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
use \UnexpectedValueException;
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
                . json_encode($this->validStorageFlags) . '; Yet supplied: ('
                . gettype($flags) .') ' . var_export($flags, true)
            );
        }

        $this->storageFile = realpath($path);
        $this->storageFlags = $flags;
    }

    /**
     * Get data from storage.
     *
     * @return string
     * @throws \RuntimeException when the file could not be accessed
     * @throws \UnexpectedValueException when the storage file did not return a string
     */
    public function get()
    {
        $readable = new Readable;

        if (!$readable($this->storageFile)) {
            throw new RuntimeException(
                "The storage file has become inaccessable: {$this->storageFile}"
            );
        }

        // Retrieve the contents of the storage file.
        $rv = file_get_contents($this->storageFile);

        $string = new String;

        if (!$string($rv)) {
            throw new UnexpectedValueException(
                'The storage file gave back an unexpected value: (' . gettype($rv)
                . ') ' . var_export($rv, true)
            );
        }

        return $rv;
    }

    /**
     * Store supplied data in the storage file.
     *
     * @param string $data
     * @throws \InvalidArgumentException when anything but a string is supplied
     * @throws \RuntimeException when the file has become inaccessable
     * @throws \RuntimeException when the data could not be stored (whole)
     */
    public function store($data)
    {
        $string = new String;

        if (!$string($data)) {
            throw new InvalidArgumentException(
                'Only strings can stored in a file: (' . gettype($data) . ') '
                . var_export($data, true)
            );
        }

        $writable = new Writable;

        if (!$writable($this->storageFile)) {
            throw new RuntimeException(
                "The storage file has become inaccessable: {$this->storageFile}"
            );
        }

        $bytesIn = strlen($data);
        $bytesStored = file_put_contents(
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
