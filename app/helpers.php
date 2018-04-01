<?php
if ( ! function_exists('config_path'))
{
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

function notFoundResponse() {
    $response = [
        'status' => 'error',
        'error'=> 'not found',
        'message' => 'Not found',
    ];

    if (env('APP_DEBUG', false)) {
        $response += ['debug' => \DB::getQueryLog()];
    }

    return response($response, 404);
}

function successResponse($values, $message = false) {
    $response = [
        'status' => 'success',
        'values' => $values,
    ];

    if (env('APP_DEBUG', false)) {
        $response += ['debug' => \DB::getQueryLog()];
    }

    if ($message) {
        $response += ['message' => $message];
    }

    return response($response, 200);
}