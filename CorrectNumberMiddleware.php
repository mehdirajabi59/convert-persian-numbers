<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * This middleware converts Persian and Arabic numbers in specified JSON fields to English numbers.
 * It ensures consistency in the number representation.
 */
class CorrectNumberMiddleware
{
    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, Closure $next, ...$params)
    {
        $this->clean($request, $params);

        return $next($request);
    }

    /**
     * Clean the JSON data by converting specified fields' numbers to English numbers.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   $params  array list of JSON field names to be processed
     * @return void
     */
    private function clean(Request $request, array $params): void
    {
        foreach ($params as $name) {
            // Check if the field exists and is a string
            if ($request->has($name) && is_string($request->{$name})) {
                $request->replace([
                    $name => $this->convertToEnglish($request->{$name}),
                ] + $request->all());
            }
        }
    }

    /**
     * Convert Persian and Arabic numbers to English numbers.
     *
     * @param  string  $content
     * @return string
     */
    protected function convertToEnglish(string $content): string
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '٤', '۵', '٥', '۶', '٦', '۷', '۸', '۹'];
        $english = [0, 1, 2, 3, 4, 4, 5, 5, 6, 6, 7, 8, 9];

        return str_replace($persian, $english, $content);
    }
}
