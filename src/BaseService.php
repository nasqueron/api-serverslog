<?php

namespace Nasqueron\Api\ServersLog;

use Exception;

class BaseService {

    ///
    /// Helper methods
    ///

    protected function getBodyObject () {
        $content= file_get_contents('php://input');

        switch ($_SERVER["HTTP_CONTENT_TYPE"]) {
            case "application/json":
                return json_decode($content);

            default:
                throw new Exception("Unknown content type.");
        }
    }

    protected function sendSuccessResponse () {
        // HTTP 200 OK
    }

    protected function sendInvalidMethodResponse () {
        header("HTTP/1.0 405 Method Not Allowed");
        http_response_code(405);
    }

}
