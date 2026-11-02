<?php

/**
 * Smart Academy — json_output_helper.php
 * Replaces CI3 application/helpers/json_output_helper.php.
 */

if (! function_exists('jsonSuccess')) {
    function jsonSuccess($data = null, string $message = 'Success', int $status = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $status);
    }
}

if (! function_exists('jsonError')) {
    function jsonError(string $message = 'Error', $errors = null, int $status = 400)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }
}

if (! function_exists('jsonResponse')) {
    function jsonResponse(bool $success, $data = null, string $message = '', int $status = 200)
    {
        return response()->json([
            'status'  => $success ? 'success' : 'error',
            'message' => $message,
            'data'    => $data,
        ], $status);
    }
}
