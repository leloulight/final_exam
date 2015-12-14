<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level';

    protected $fillable = ['name', 'role_id'];

    public $timestamps = false;

    public function staff(){
    	return $this->hasMany('App\Staff','level_id');
    }

    public function role(){
    	return $this->belongsTo('App\Role', 'role_id');
    }
}
