<?php

use Nasqueron\Api\ServersLog\Log;
use Nasqueron\Api\ServersLog\LogEntry;

use PHPUnit\Framework\TestCase;

class LogTest extends TestCase {

    ///
    /// Tests
    ///

    public function testAdd () {
        $log = new Log;

        for ($i = 0 ; $i < 5 ; $i++) {
            $log->add(new LogEntry);
        }

        $entriesCount = count($log->getAll());

        $this->assertEquals(5, $entriesCount);
    }

    public function testGetAllWhenLogIsEmpty () {
        $log = new Log;

        $this->assertEquals([], $log->getAll());
    }

    public function testGetAllWhenLogContainsEntries () {
        $log = new Log;
        $log->add(new LogEntry);

        foreach ($log->getAll() as $entry) {
            $this->assertInstanceOf(
                "Nasqueron\\Api\\ServersLog\\LogEntry",
                $entry
            );
        }
    }

    public function testToJson () {
        $log = new Log;
        $log->add($this->getSampleLogEntry());

        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . "/log.json",
            $log->toJSON()
        );
    }

    public function testFillFromJSON () {
        $json = file_get_contents(__DIR__ . "/log.json");
        $log = new Log;
        $log->fillFromJSON($json);

        $entries = $log->getAll();
        $entry = $entries[0];

        $this->assertInstanceOf(
            "Nasqueron\\Api\\ServersLog\\LogEntry",
            $entry
        );
    }

    public function testLoadFromJSONFile () {
        $log = Log::loadFromJSONFile(__DIR__ . "/log.json");

        $this->assertInstanceOf(
            "Nasqueron\\Api\\ServersLog\\Log",
            $log
        );

        $entries = $log->getAll();
        $this->assertEquals(1, count($entries));

        $entry = $entries[0];
        $this->assertEquals("Acme", $entry->component);
        $this->assertEquals("1974", $entry->date);
        $this->assertInstanceOf(
            "Nasqueron\\Api\\ServersLog\\LogEntry",
            $entry
        );
    }

    public function testAddEntryToJSONFile () {
        $logFilename = tempnam(
            sys_get_temp_dir(),
            'ServersLogTest'
        );
        file_put_contents(
            $logFilename,
            file_get_contents(__DIR__ . "/log.json")
        );

        Log::addEntryToJSONFile(
            $logFilename,
            $this->getSampleLogEntry()
        );

        $log = Log::loadFromJSONFile($logFilename);
        $entriesCount = count($log->getAll());
        $this->assertEquals(2, $entriesCount);

        unlink($logFilename);

    }

    ///
    /// Helper methods
    ///

    private function getSampleLogEntry () {
        $entry = new Logentry;

        $entry->component = "Acme";
        $entry->date = "1974";
        $entry->emitter = "Tests";
        $entry->entry = "Something happens.";
        $entry->source = "LogTest.php";

        return $entry;
    }

}
