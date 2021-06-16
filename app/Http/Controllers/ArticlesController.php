<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;

class ArticlesController extends Controller
{
    public function all()
    {
        $sort = request('sort') ?? 'created_at';
        $order= request('order') ?? 'desc';
        $limit = request('limit') ?? 10;
        $paginate = request('paginate');
        try {
            $query = Article::with('tags')
                ->LeftJoin('article_comment', 'articles.id', '=', 'article_comment.article_id')
                ->LeftJoin('comments', 'comments.id', '=', 'article_comment.comment_id')
                ->select('articles.*', DB::raw('COUNT(comments.id) as comment_count'))
                ->groupBy('articles.id')
                ->orderBy($sort, $order)
                ->limit($limit);
            return response()->json([$paginate ? $query->paginate($paginate) : $query->get()], 200);
        }
        catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 400);
        }
    }

    public function comments($id)
    {
        $sort = request('sort') ?? 'created_at';
        $order= request('order') ?? 'desc';
        try {
            $article = Article::findOrFail($id);
            return response()->json([$article->comments()->orderBy($sort, $order)->get()], 200);
        }
        catch (\Exception $ex) {
            return response()->json($ex->getMessage(),400);
        }

    }

    public function tags()
    {
        $sort = request('sort') ?? 'article_count';
        $order= request('order') ?? 'desc';
        try {
           $query =  Tag::query()
               ->LeftJoin('article_tag', 'tags.id', '=', 'article_tag.tag_id')
               ->LeftJoin('articles', 'articles.id', '=', 'article_tag.article_id')
               ->select('tags.*', DB::raw('COUNT(articles.id) as article_count'))
               ->groupBy('tag_id')
               ->orderBy($sort, $order)
               ->get();
        }
        catch (\Exception $ex) {
            return response()->json($ex->getMessage(),400);
        }
        return $query;
    }

    public function tagArticles($id)
    {
        $tag = Tag::find($id);
        $sort = request('sort') ?? 'created_at';
        $order= request('order') ?? 'desc';
        $limit = request('limit') ?? 10;
        $paginate = request('paginate');
        try {
            $query = Article::with('tags')
                ->join('article_tag', 'articles.id', '=', 'article_tag.article_id')
                ->join('tags', 'tags.id', '=', 'article_tag.tag_id')
                ->where('tags.id', '=', $tag->id)
                ->LeftJoin('article_comment', 'articles.id', '=', 'article_comment.article_id')
                ->LeftJoin('comments', 'comments.id', '=', 'article_comment.comment_id')
                ->select('articles.*', DB::raw('COUNT(comments.id) as comment_count'))
                ->groupBy('articles.id')
                ->orderBy($sort, $order)
                ->limit($limit);
            return response()->json([$paginate ? $query->paginate($paginate) : $query->get()], 200);
        }
        catch (\Exception $ex) {
            return response()->json($ex->getMessage(),400);
        }
    }
}
