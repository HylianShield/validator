<?php
/**
 * Factory for configuration objects.
 *
 * @package HylianShield
 * @subpackage Configuration
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Configuration;

use \HylianShield\Configuration;

/**
 * Factory.
 */
class Factory
{
    /**
     * The serializer for JSON.
     *
     * @const string SERIALIZER_JSON
     */
    const SERIALIZER_JSON = '\HylianShield\Serializer\JsonConf';

    /**
     * Get the configuration from a given JSON file.
     *
     * @param string $file
     * @return \HylianShield\Configuration
     */
    public static function getFromJsonFile($file)
    {
        $data = self::getConfigFromFile($file);

        $config = new Configuration;
        $config->setSerializer(self::SERIALIZER_JSON);
        $config->setStorage($file);
        $config->unserialize($data);

        return $config;
    }

    /**
     * Read out and get the configuration from a given file.
     *
     * @param string $file
     * @return string $config
     * @throws \InvalidArgumentException when $file is not a file path
     * @throws \RuntimeException when $file is not readable
     * @throws \UnexpextedValueException when the contents of $file are empty
     */
    private static function getConfigFromFile($file)
    {
        if (!is_string($file) || !file_exists($file)) {
            throw new InvalidArgumentException(
                'Invalid configuration file supplied: (' . gettype($file)
                . ') ' . var_export($file, true)
            );
        }

        if (!is_readable($file)) {
            throw new RuntimeException(
                "The configuration file is not readable: {$file}"
            );
        }

        // Get the configuration from the file.
        $config = @trim(file_get_contents($file));

        if (empty($config)) {
            throw new UnexpextedValueException(
                "The configuration file was empty: {$file}"
            );
        }

        return $config;
    }
}
