<?php

namespace App\Http\Middleware;

use App\Traits\JsonResponseTrait;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyProfileIsUpdated
{
    use JsonResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response|JsonResponse|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse|RedirectResponse
    {
        if (is_null($request->user()->profile->age)) {
            return $this->error(
                'You need to update your profile to continue.',
                Response::HTTP_PRECONDITION_FAILED
            );
        }

        return $next($request);
    }
}
