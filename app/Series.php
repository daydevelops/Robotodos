<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
	protected $fillable = ['name'];

    public function articles() {
		return $this->hasMany(\App\Article::class)->orderBy('number_in_series','ASC');
	}

	public function add($article) {
		$article->update(['series_id'=>$this->id]);
	}


    /**
     * checkAuth
     *
     * @author Huiwang <905130909@qq.com>
     *
     * @param $query
     * @return mixed
     */
    public function scopeCheckAuth($query)
    {
        if (auth()->check() && auth()->user()->is_admin) {
            $query->withoutGlobalScope(DraftScope::class);
        }
        return $query;
    }
}
