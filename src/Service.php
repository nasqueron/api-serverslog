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

    private function isAliveRequest() : bool {
        return
            $_SERVER['REQUEST_METHOD'] === "GET"
        &&
            $_SERVER['REQUEST_URI'] === '/status';
    }

    public function handle () : void {
        if ($this->isAliveRequest()) {
            $this->sendSuccessResponse("ALIVE");
        } elseif ($_SERVER['REQUEST_METHOD'] === "PUT") {
            $body = $this->getBodyObject();
            $this->put($body);
        } else {
            $this->sendInvalidMethodResponse();
        }
    }

    public function put ($data) : void {
        if ($data === NULL) {
            $this->sendBadRequestResponse();
            return;
        }

        $log = self::getServersLogFile();
        if (!$log) {
            $this->sendInternalServerError();
            return;
        }

        Log::addEntryToJSONFile(
            $log,
            LogEntry::fromJSON($data)
        );

        $this->sendSuccessResponse();
    }

    ///
    /// Helper methods
    ///

    private function loadEnvironment () : void {
        $env = Dotenv::createUnsafeImmutable(__DIR__);
        if (file_exists(__DIR__ . '/.env')) {
            $env->load();
        }
        $env->required('SERVERS_LOG_FILE');
    }

    private static function getServersLogFile () : string {
        return getenv('SERVERS_LOG_FILE');
    }

}
