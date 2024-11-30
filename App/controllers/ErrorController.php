<?php

namespace App\controllers;

class ErrorController
{

    /**
     * page not found error
     *
     * @param string $message
     * @return void
     */
    public static function notFound($message = "Page Not Found")
    {
        http_response_code(404);
        loadView('error/error', [
            'status' => 404,
            "message" => $message
        ]);
    }

    /**
     * unAuthorized error
     *
     * @param string $message
     * @return void
     */
    public static function unAuthorized($message = "You are not authorized to access this page")
    {
        http_response_code(403);
        loadView('error/error', [
            'status' => 403,
            'message' => $message
        ]);
    }
}
