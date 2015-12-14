<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Staff;
use Auth;
use App\Level;
use App\Role;
use App\Review;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function leaderReview(Staff $staff, Staff $staff_2)
    {
        if($staff->level->role->name == 'Manager' || $staff->department_id != $staff_2->department_id || $staff->id == $staff_2->id){
            return false;
        }
        return true;
    }


}
