<?php

namespace App\Ship\Middlewares\Http;

use App\Ship\Exceptions\MissingJSONHeaderException;
use App\Ship\Abstracts\Middlewares\Middleware;
use Closure;
use Illuminate\Http\Request;

class ValidateJsonContent extends Middleware
{
    /**
     * @throws MissingJSONHeaderException
     */
    public function handle(Request $request, Closure $next)
    {
        $acceptHeader = $request->header('accept');
        $contentType = 'application/json';

        // check if to accept header is set to application/json
        // if forcing users to accept header is enabled, then throw an exception
        if (!str_contains($acceptHeader, $contentType) && config('laraneat.requests.force-accept-header')) {
            throw new MissingJSONHeaderException();
        }

        // the request has to be processed, so get the response after the request is done
        $response = $next($request);

        // set Content Languages' header in the response | always return Content-Type application/json in the header
        $response->headers->set('Content-Type', $contentType);

        // if request doesn't contain in header accept = application/json. Return a warning in the response
        if (!str_contains($acceptHeader, $contentType)) {
            $warnCode = '199'; // https://www.iana.org/assignments/http-warn-codes/http-warn-codes.xhtml
            $warnMessage = 'Missing request header [ accept = ' . $contentType . ' ] when calling a JSON API.';
            $response->headers->set('Warning', $warnCode . ' ' . $warnMessage);
        }

        // return the response
        return $response;
    }
}
