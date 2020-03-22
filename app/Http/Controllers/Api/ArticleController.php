<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Subscriber;
use App\Scopes\DraftScope;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Jobs\NotifySubscribers;
use App\Mail\NewArticlePublished;
use App\User;
use Illuminate\Support\Facades\Mail;

class ArticleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        $articles = Article::checkAuth()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('subtitle', 'like', "%{$keyword}%");
            })
            ->orderBy('created_at', 'desc')->paginate(10);

        return $this->response->collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ArticleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ArticleRequest $request)
    {
        $data = array_merge($request->all(), [
            'user_id' => \Auth::id(),
            'last_user_id' => \Auth::id(),
        ]);

        $data['is_draft'] = isset($data['is_draft']);
        $data['is_original'] = isset($data['is_original']);

        $article = new Article();
        $article->fill($data);
        $article->save();

        $article->tags()->sync(json_decode($request->get('tags')));

        return $this->response->withNoContent();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $article = Article::withoutGlobalScope(DraftScope::class)->findOrFail($id);

        return $this->response->item($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ArticleRequest $request
     * @param int                               $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ArticleRequest $request, $id)
    {
        $data = array_merge($request->all(), [
            'last_user_id' => \Auth::id(),
        ]);
        $article = Article::withoutGlobalScope(DraftScope::class)->findOrFail($id);
        $article->update($data);

        $article->tags()->sync(json_decode($request->get('tags')));

        return $this->response->withNoContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Article::withoutGlobalScope(DraftScope::class)->findOrFail($id)->delete();

        return $this->response->withNoContent();
    }

	public function notifyTest(Request $request, Article $article) {
		if (!auth()->user()->is_admin) {
			return response()->json([],403);
        }
        Mail::to(auth()->user())->send(new NewArticlePublished($article,"mykey"));
        if (!Mail::failures()) {
            return response()->json([],200);
        } else {
            return response()->json([],500);
        }
    }
    
    public function notify(Request $request, Article $article) {
		if (!auth()->user()->is_admin) {
			return response()->json([],403);
        }
        $subscribers = Subscriber::all()->toArray();

        NotifySubscribers::dispatch($subscribers,$article);
    }
}
