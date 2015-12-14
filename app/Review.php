<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';

    protected $fillable = ['staff_id', 'reviewer_id', 'point', 'comment', 'active'];

    public function staff(){
    	return $this->belongsTo('App\Staff', 'reviewer_id');
    }
}
