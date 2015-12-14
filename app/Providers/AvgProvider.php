<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Review;
use Carbon\Carbon;

class AvgProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public static function average($param){
        // average review of last month
        $average = Review::where(['active'=> 1, 'staff_id' => $param ])->whereBetween('created_at', [Carbon::now()->subMonths(1)->startOfMonth(), Carbon::now()->subMonths(1)->endOfMonth()])->get();
        $avg = collect($average);

        return $avg->avg('point');

    }
}
