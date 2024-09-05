<?php

namespace App\Http\Middleware;

use App\Repositories\Preferences;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfSettingsNotValid
{
    public function __construct(
        protected Preferences $preferences,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->preferences->valid() === false) {
            return redirect('/settings');
        }

        return $next($request);
    }
}
