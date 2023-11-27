<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;


class JwtMiddleware
{

    /**
     *  middleware that checks if the user has a valid JWT to access a protected route
     * It uses the FacadesJWTAuth class to parse the token from the request and authenticate the user
     * If the token is invalid, expired, or not found, it returns a JSON response with an appropriate status message.
     *  Otherwise, it passes the request to the next middleware
     */

    public function handle(Request $request, Closure $next): Response
    {

        // Try to parse and authenticate the token
        try {

            // Use the FacadesJWTAuth class to get the user from the token
            $user = FacadesJWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {

            // If an exception occurs, check the type of exception
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {

                // If the token is invalid, return a JSON response with status ‘Token is Invalid’
                return response()->json(['status' => 'Token is Invalid']);

                // If the token is expired, return a JSON response with status ‘Token is Expired’
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {

                // If the token is not found, return a JSON response with status ‘Authorization Token not found’
                return response()->json(['status' => 'Token is Expired']);

                // If the token is not found, return a JSON response with status ‘Authorization Token not found’
            } else {

                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        // If no exception occurs, pass the request to the next middleware
        return $next($request);
    }
}
