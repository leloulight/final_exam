<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'team';

    protected $fillable = ['name'];

    public $timestamps = false;

    public function staff(){
        return $this->belongsToMany('App\Staff', 'staff_team');
    }
}
