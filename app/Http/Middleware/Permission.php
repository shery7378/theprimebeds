<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class Permission
{
    public function handle($request, Closure $next, $data)
    {
        if (Auth::guard("admin")->check()) {
            // Super admin (ID=1) bypasses all checks
            if (Auth::guard("admin")->user()->id == 1) {
                return $next($request);
            }

            // No role assigned
            if (Auth::guard("admin")->user()->role_id == 0) {
                return redirect()
                    ->route("back.dashboard")
                    ->with("success", "You don't have access to that section");
            }

            // Support pipe | OR logic: e.g. "Add Categories|Update Categories|Delete Categories"
            $permissions = explode("|", $data);

            foreach ($permissions as $permission) {
                if (
                    Auth::guard("admin")
                        ->user()
                        ->sectionCheck(trim($permission))
                ) {
                    return $next($request);
                }
            }
        }

        return redirect()
            ->route("back.dashboard")
            ->with("success", "You don't have access to that section");
    }
}
