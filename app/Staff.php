<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Staff extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{

    use Authenticatable, Authorizable, CanResetPassword;

    
    protected $table = 'staff';

    protected $fillable = ['name', 'birth', 'position_id', 'level_id', 'phone', 'department_id', 'email'];

    public $timestamps = false;

    protected $hidden = ['password', 'remember_token'];


    public function position(){
    	return $this->belongsTo('App\Position', 'position_id');
    }

    public function level(){
    	return $this->belongsTo('App\Level', 'level_id');
    }

    public function department(){
    	return $this->belongsTo('App\Department', 'department_id');
    }

    public function team(){
        return $this->belongsToMany('App\Team', 'staff_team');
    }

    public function staff_team(){
        return $this->hasMany('App\StaffTeam', 'staff_id');
    }
}
