<?php

namespace Apiauth\Laravel\Middleware;

use Closure;

class CheckAuth
{
    const CODE = 401;
    const MESSAGE = 'Unauthorized';
    
    /**
     * Handle an incoming request.
     *      
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $service
     * @return mixed
     */
    public function handle($request, Closure $next, $service)
    {
        if (! $this->authorized($request, $service)) {
            return response(self::CODE, self::MESSAGE);
        }

        return $next($request);
    }

    /**
     * Checks an incoming token against one in configs
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function authorized($request, $service)
    {
        $cfg = $this->getConfigs($service);

        if ($cfg['allowBearerToken'] && $cfg['token'] === $request->bearerToken()) {
            return true;
        }

        if ($cfg['allowJsonToken'] && $cfg['token'] === $request->input($cfg['tokenName'])) {
            return true;
        }

        if ($cfg['allowRequestToken'] && $cfg['token'] === $request->get($cfg['tokenName'])) {
            return true;
        }

        return false;
    }

    /**
     * Returns config array for a given service
     *
     * @param $service
     * @return mixed
     */
    public function getConfigs($service)
    {
        return config('apiauth.services.' . $service);
    }
}
