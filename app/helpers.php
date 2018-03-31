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