<?php

namespace Nasqueron\Api\ServersLog;

use Dotenv\Dotenv;

class Service extends BaseService {

    ///
    /// Initialisation
    ///

    public function __construct () {
        $this->loadEnvironment();
    }

    ///
    /// Controller
    ///

    public function handle () : void {
        $body = $this->getBodyObject();

        if ($_SERVER['REQUEST_METHOD'] === "PUT") {
            $this->put($body);
            return;
        }

        $this->sendInvalidMethodResponse();
    }

    public function put ($data) : void {
        Log::addEntryToJSONFile(
            self::getServersLogFile(),
            LogEntry::fromJSON($data)
        );

        $this->sendSuccessResponse();
    }

    ///
    /// Helper methods
    ///

    private function loadEnvironment () : void {
        $env = new Dotenv(__DIR__);
        if (file_exists(__DIR__ . '/.env')) {
            $env->load();
        }
        $env->required('SERVERS_LOG_FILE');
    }

    private static function getServersLogFile () : string {
        return getenv('SERVERS_LOG_FILE');
    }

}
