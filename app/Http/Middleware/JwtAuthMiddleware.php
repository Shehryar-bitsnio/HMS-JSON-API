<?php

namespace App\Http\Middleware;

use App\Traits\HelperTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\UserNotDefinedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\InvalidClaimException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use App\Traits\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JwtAuthMiddleware
{
    use HelperTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {

            if ($e instanceof TokenInvalidException) {
                return $this->errorResponse('Token is Invalid', $e->getMessage(),  401);
            } else if ($e instanceof TokenExpiredException) {
                return $this->errorResponse('Token is Expired', $e->getMessage(),  401);
            } else if ($e instanceof UserNotDefinedException) {
                return $this->errorResponse('User Does not Exists', $e->getMessage(),  401);
            }
            else {
                return $this->errorResponse($e->getMessage(), $e->getMessage(),  401);
            }
        }
        return $next($request);
    }

    public function pathToExcludeFromMiddleware(): array
    {
        return [
            'login',
            'register'
        ];
    }
}
