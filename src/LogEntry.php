<?php

namespace Nasqueron\Api\ServersLog;

use JsonMapper;

class LogEntry {

    ///
    /// Public properties
    ///

    public $date = "";

    public $emitter = "";

    public $source = "";

    public $component = "";

    public $entry = "";

    ///
    /// Constructor
    ///

    public function __construct () {
        $this->date = self::getCurrentTimestamp();
    }

    ///
    /// Helper methods
    ///

    // Helper methods
    private static function getCurrentTimestamp () : string {
        // Nasqueron log format: 2016-02-13T23:14:00Z (with a final Z for UTC)
        return str_replace("+00:00", "Z", gmdate('c'));
    }

    public static function fromJSON ($json) : LogEntry {
        $mapper = (new JsonMapper());
        return $mapper->map($json, new LogEntry);
    }

}
