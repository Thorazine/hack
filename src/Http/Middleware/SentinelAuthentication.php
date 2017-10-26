<?php

namespace Thorazine\Hack\Http\Middleware;

use Thorazine\Hack\Models\Auth\HackPersistence;
use Thorazine\Hack\Scopes\SiteScope;
use Sentinel;
use Closure;
use Hack;

class SentinelAuthentication
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
        if($user = Sentinel::getUser()) {

            // lazy load the roles
            $user->roles;

            // lazy load the users image
            $user->load(['gallery' => function($query) {
                $query->withoutGlobalScope(SiteScope::class);
            }]);

            // make a request cache version of the user
            Hack::setUser($user);

            // set the persistence code with the request
            Hack::setCode($request);

            // get all the users rights
            $permissions = $this->getPermissions($user);

            // set the rights
            Hack::setRights($permissions);

            if($persistence = HackPersistence::active()->first()) {

                $user = Hack::setPersistence($persistence);

                // update persistence last used time
                HackPersistence::where('id', $persistence->id)->update([
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                // set the cms language as defined by the user
                Hack::setLanguage();

                if(in_array($this->replaceEndOfRight(Hack::siteId().'.'.$request->route()->getName()), $permissions) || in_array($request->route()->getName(), config('cms.rights.excluded'))) {
                    return $next($request);
                }
                else {
                    if($request->ajax()) {
                        return response()->json('Unauthorized', 403);
                    }
                    return redirect()->back()->with('alert-info', 'Sorry, you do not have permission to access that page');
                }
            }

            if(in_array($request->route()->getName(), ['hack.auth.persistence', 'hack.auth.persistence.resend'])) {
                return $next($request);
            }

            return redirect()->route('hack.auth.persistence');
        }

        return redirect()->route('hack.auth.index');
    }


    /**
     * Take all the users permissions and make an array from it
     */
    protected function getPermissions($user)
    {
        $permissions = $user->permissions;

        foreach($user->roles as $role) {
            $permissions = array_merge($permissions, $role->permissions);
        }

        return $permissions;
    }


    /**
     * Replace the store right with create and update with edit
     */
    protected function replaceEndOfRight($permission)
    {
        $routeArr = explode('.', $permission);

        if(in_array(end($routeArr), ['store'])) {
            array_pop($routeArr);
            return implode('.', $routeArr).'.create';
        }
        elseif(in_array(end($routeArr), ['update', 'publish'])) {
            array_pop($routeArr);
            return implode('.', $routeArr).'.edit';
        }
        elseif(in_array(end($routeArr), ['order'])) {
            array_pop($routeArr);
            return implode('.', $routeArr).'.index';
        }

        return $permission;
    }
}
