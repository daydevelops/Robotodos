<?php

namespace App\Http\Controllers;

use App\Article;
use App\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display the articles resource.
     *
     * @return mixed
     */
    public function index()
    {
        $seriess = Series::with('articles')->paginate(config('blog.article.number'));
		$trending_article = Article::orderBy('view_count','DESC')->first();
        return view('series.index', compact('seriess','trending_article'));
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
    public function show(Request $request, Series $series)
    {
        $articles = $series->articles()
            ->orderBy(config('blog.article.sortColumn'), config('blog.article.sort'))
            ->paginate(config('blog.article.number'));
		$trending_article = Article::orderBy('view_count','DESC')->first();
        return view('series.show', compact('series','articles','trending_article'));
    }
}
