<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class AdminLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $language = Language::whereType('Dashboard')->where('is_default', 1)->first();
        App::setlocale($language->name);

        // Merchant URL prefix handling
        $adminUser = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        if ($adminUser) {
            $segment = $request->segment(1);
            $isMerchant = ($adminUser->role && strtolower($adminUser->role->name) == 'merchant');
            
            if ($isMerchant && $segment === 'admin' && $request->isMethod('get')) {
                $segments = $request->segments();
                $segments[0] = 'merchant';
                return redirect()->to(implode('/', $segments) . ($request->getQueryString() ? '?' . $request->getQueryString() : ''));
            }
            
            if (!$isMerchant && $segment === 'merchant' && $request->isMethod('get')) {
                $segments = $request->segments();
                $segments[0] = 'admin';
                return redirect()->to(implode('/', $segments) . ($request->getQueryString() ? '?' . $request->getQueryString() : ''));
            }
        }

        return $next($request);
    }
}
