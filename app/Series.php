<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    public function articles() {
		return $this->hasMany(\App\Article::class)->orderBy('number_in_series','ASC');
	}
}
