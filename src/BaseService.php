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

    protected function sendSuccessResponse ($responseBody = '') {
        // HTTP 200 OK
        echo $responseBody;
    }

    protected function sendBadRequestResponse () {
        header("HTTP/1.0 400 Bad Request");
        http_response_code(400);
    }

    protected function sendInvalidMethodResponse () {
        header("HTTP/1.0 405 Method Not Allowed");
        http_response_code(405);
    }

    protected function sendInternalServerErrorResponse () {
        header("HTTP/1.0 500 Internal Server Error");
        http_response_code(500);
    }

}
