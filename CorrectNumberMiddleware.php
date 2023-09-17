<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;

/**
 * This middleware converts Persian and Arabic numbers in specified JSON fields to English numbers.
 * It ensures consistency in the number representation.
 */
class CorrectNumberMiddleware
{
    public function handle($request, Closure $next, ...$params)
    {
        $this->clean($request, $params);

        return $next($request);
    }

    /**
     * Clean the JSON data by converting specified fields' numbers to English numbers.
     * @param $json
     * @param $params array list of JSON field names to be processed
     * @return void
     */
    private function clean($json, array $params): void
    {
        array_map(function ($fieldName) use ($json){
            if ($json->has($fieldName)) {
                $json->replace(
                    [$fieldName  => $this->convertNumbers($json->get($fieldName))] +
                    $json->all()
                );
            }
        }, $params);
    }

    /**
     * Convert Persian and Arabic numbers to English numbers
     * @param $content
     * @return int Converted content with English numbers
     */
    protected function convertNumbers($content): int
    {

        $persian    = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $en         = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        array_map(function($persian, $en) use (&$content){
            $content = str_replace($persian, $en, $content);
        } , $persian, $en);

        return $content;
    }


}
