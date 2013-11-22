<?php
/**
 * The autoloader for our code base. This is purely for testing purposes.
 *
 * @package HylianShield
 * @subpackage Autoloader
 * @copyright 2013 Hotels.nl
 */

use \InvalidArgumentException;
use \RuntimeException;

/**
 * Autoloader.
 */
class Autoloader
{
    /**
     * The path to our code base.
     *
     * @var string $path
     */
    private $path;

    /**
     * List of paths to loaded classes.
     *
     * @var array $loaded
     */
    private $loaded = array();

    /**
     * Construct the autoloader.
     *
     * @param string $path
     * @throws \InvalidArgumentException when $path is not a directory
     */
    public function __construct($path)
    {
        if (!is_dir($path)) {
            throw new InvalidArgumentException(
                'Supplied path is not a valid directory: ('
                . gettype($path) . ') ' . var_export($path, true)
            );
        }

        $this->path = realpath($path) . '/';

        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * Try to automatically load a class.
     *
     * @param string $class
     * @return void
     * @throws RuntimeException if class could not be loaded
     */
    public function loadClass($class)
    {
        // Nothing to see here. The class has already been loaded once.
        if (array_key_exists($class, $this->loaded)) {
            return;
        }

        if (class_exists($class, false)) {
            $path = "PHP_Core::{$class}";
        } else {
            // Get the path of the class file and include it.
            $path = $this->getPath($class);

            if (empty($path)) {
                throw new RuntimeException(
                    "Supplied class could not be found in our path: {$this->path}"
                );
            }

            // Include the class.
            include_once $path;
        }

        // Store the class in the loaded array.
        $this->loaded[$class] = $path;
    }

    /**
     * Get the file path for a given class.
     *
     * Only works for classes that adhere to PSR-0.
     *
     * @param string $class name
     * @return boolean|string file name or false
     */
    private function getPath($class)
    {
        // Replace commonly used class breaking points in the class name to construct
        // a proper file path.
        $path = $this->path . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

        if (!file_exists($path)) {
            return false;
        }

        return $path;
    }
}
