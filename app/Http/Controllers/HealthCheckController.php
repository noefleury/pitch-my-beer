<?php

namespace App\Http\Controllers;

use Tests\Feature\HealthCheckTest;

/**
 * @see HealthCheckTest
 */
class HealthCheckController extends Controller
{

    public function ping()
    {
        return response()->json(['data' => 'pong']);
    }

    public function pingServer()
    {
        return response()
            ->json([
                'laravel_version'     => app()->version(),
                'php_version'         => phpversion(),
                'processing_duration' => microtime(true) - LARAVEL_START,
            ]);
    }

}
