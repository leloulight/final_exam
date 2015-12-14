<?php

namespace App\Providers;

use App\Staff;
use App\Policies\ReviewPolicy;
use App\Review;
use Auth;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        Review::class => ReviewPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('check-admin', function () {
            $role = Auth::user()->level()->first()->role()->first()->name;
            if($role == "SystemAdmin"){
                return TRUE;
            }
            else{
                return FALSE;
            }
        });

        $gate->define('check-manager', function () {
            $role = Auth::user()->level()->first()->role()->first()->name;
            if($role == "Manager"){
                return TRUE;
            }
            else{
                return FALSE;
            }
        });

        $gate->define('check-leader', function () {
            $role = Auth::user()->level()->first()->role()->first()->name;
            if($role == "TeamLeader"){
                return TRUE;
            }
            else{
                return FALSE;
            }
        });

        $gate->define('check-developer', function () {
            $role = Auth::user()->level()->first()->role()->first()->name;
            if($role == "Developer"){
                return TRUE;
            }
            else{
                return FALSE;
            }
        });

        $gate->define('update-team', function ($user, $team) {
            return $user->id === $team->creator;
        });
    
    }
}
