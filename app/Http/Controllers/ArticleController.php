<?php

namespace App\Http\Controllers;

use App\Article;
use App\Visitor;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display the articles resource.
     *
     * @return mixed
     */
    public function index()
    {
        $articles = Article::checkAuth()
            ->orderBy(config('blog.article.sortColumn'), config('blog.article.sort'))
            ->paginate(config('blog.article.number'));
		$trending_article = Article::orderBy('view_count','DESC')->first();
        return view('article.index', compact('articles','trending_article'));
    }

    /**
     * Display the article resource by article slug.
     *
     * @author Huiwang <905130909@qq.com>
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $slug)
    {
        $article = Article::checkAuth()->where('slug', $slug)->firstOrFail();

        $article->increment('view_count');

        $ip = $request->getClientIp();

        if ($ip == '::1') {
            $ip = '127.0.0.1';
        }

        Visitor::log($article->id, $ip);

		if ($article->nextArticle()) {
			$trending_article = $article->nextArticle();
		} else {
			$trending_article = Article::orderBy('view_count','DESC')->first();
		}
		
        return view('article.show', compact('article','trending_article'));
    }
}
