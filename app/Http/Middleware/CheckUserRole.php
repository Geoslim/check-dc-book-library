<?php

namespace App\Http\Middleware;

use App\Traits\JsonResponseTrait;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    use JsonResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $role
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next, $role): Response|JsonResponse|RedirectResponse
    {
        $roles = is_array($role) ? $role : explode('|', $role);


        if ($request->user()->roles()->whereIn('slug', $roles)->exists()) {
            return $next($request);
        }

        return $this->error(
            "UNAUTHORIZED, You do not have the role required.",
            Response::HTTP_FORBIDDEN
        );
    }
}
