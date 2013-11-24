<?php
/**
 * A storage adapter for HylianShield configurations.
 *
 * @package HylianShield
 * @subpackage Storage
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Storage;

/**
 * Adapter.
 */
abstract class Adapter
{
    /**
     * Store data in the storage. It is expected that it is somehow ensured that
     * this data will be saved one way or the other.
     *
     * E.g. the adapter can decide that on desctruct it writes to a database.
     * However, it is suggested the adapter does this at once, since the application
     * will specifically call store.
     *
     * @param mixed $data
     * @return void
     */
    public abstract function store($data);

    /**
     * Get data from the storage.
     *
     * @return string $data
     */
    public abstract function get();
}
