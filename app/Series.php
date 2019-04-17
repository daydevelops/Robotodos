<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
	protected $fillable = ['name','description'];

    public function articles() {
		return $this->hasMany(\App\Article::class)->orderBy('number_in_series','ASC');
	}

	public function add($article) {
		$article->update([
			'series_id'=>$this->id,
			'number_in_series'=>$this->articles->count() + 1
		]);
	}

	public function remove($article_to_delete) {

		$articles_to_update = $this->articles()
		->where('number_in_series','>',$article_to_delete->number_in_series)
		->decrement('number_in_series',1);

		$article_to_delete->update([
			'series_id'=>null,
			'number_in_series'=>null
		]);
	}

    public function scopeCheckAuth($query)
    {
        if (auth()->check() && auth()->user()->is_admin) {
            $query->withoutGlobalScope(DraftScope::class);
        }
        return $query;
    }

}
