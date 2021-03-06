<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Watcher;

/**
 * Class None
 *
 * QWatcherNone is a watcher that turns off Watcher functionality. This is the default watcher. If you want to use
 * a watcher, you must specify a Watcher type in the QWatcher class in you project/include/controls directory
 *
 * @package QCubed\Watcher
 * @was QWatcherNone
 */
class None extends WatcherBase
{

    /**
     * Records the current state of the watched tables.
     */
    public function MakeCurrent()
    {
    }

    /**
     *
     * @return bool
     */
    public function IsCurrent()
    {
        return true;
    }

    /**
     * Model Save() method should call this to indicate that a table has changed.
     *
     * @param string $strTableName
     * @throws \QCubed\Exception\Caller
     */
    static public function MarkTableModified($strDbName, $strTableName)
    {
    }

    /**
     * Support function for the Form to determine if any of the watchers have changed.
     *
     * @param $strFormWatcherTime
     * @return bool
     */
    static public function FormWatcherChanged(&$strFormWatcherTime)
    {
        return false;
    }

}