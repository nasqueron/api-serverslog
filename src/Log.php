<?php

namespace Nasqueron\Api\ServersLog;

class Log {

    /**
     * @var LogEntry[]
     */
    private $entries = [];

    public function add (LogEntry $entry) : void {
        $this->entries[] = $entry;
    }

    public function getAll () : array {
        return $this->entries;
    }

    public function toJSON () : string {
        return json_encode($this->entries, JSON_PRETTY_PRINT);
    }

    public function fillFromJSON (string $json) : void {
        $entries = json_decode($json);
        foreach ($entries as $entry) {
            $this->add(LogEntry::fromJSON($entry));
        }
    }

    ///
    /// Static helper methods
    ///

    public static function loadFromJSONFile (string $filename) : Log {
        $log = new Log;

        $json = file_get_contents($filename);
        $log->fillFromJSON($json);

        return $log;
    }

    public static function addEntryToJSONFile (string $filename, LogEntry $entry) : void {
        $log = self::loadFromJSONFile($filename);
        $log->add($entry);
        file_put_contents($filename, $log->toJSON());
    }

}
