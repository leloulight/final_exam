<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffTeam extends Model
{
    protected $table = 'staff_team';

    protected $fillable = ['staff_id', 'team_id'];

    public $timestamps = false;

    public function staff(){
    	return $this->belongsTo('App\Staff', 'staff_id');
    }
}
