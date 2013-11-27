<?php
/**
 * Log file storage adapter.
 *
 * @package HylianShield
 * @subpackage Storage
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Storage\Adapter;

/**
 * LogFile.
 */
class LogFile extends \HylianShield\Storage\Adapter\File
{
    /**
     * Set up a log file storage.
     *
     * @param string $logFile
     */
    public function __construct($logFile)
    {
        parent::__construct($logFile, FILE_APPEND);
    }
}
