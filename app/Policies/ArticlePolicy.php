<?php

namespace App\Policies;

use App\User;
use App\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

	public function comment(User $user, Article $article) {
		return auth()->check() && !$article->is_draft;
	}
}
