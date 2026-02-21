<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;


class ArticleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
{
    return [
        // examples with aliases, pipe-separated names, guards, etc:
        // 'role_or_permission:manager|edit articles',
        new Middleware('permission:view-posts', only: ['index']),
        new Middleware('permission:edit-posts', only: ['edit']),
        new Middleware('permission:create-posts', only: ['create']),
        new Middleware('permission:delete-posts', only: ['destroy']),


    ];
}



    public function index()
    {
        $articles = Article::all();
        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $validator = Validator::make(
        $request->all(),
        [
            'title' => 'required',
            'content' => 'required',
            'author' => 'required'
        ]
    );

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $article = new Article();
    $article->title = $request->title;
    $article->content = $request->content;
    $article->author = $request->author;
    $article->save();

    return redirect()->route('article.index');
}

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = Article::find($id);
        // dd($article);
        return view('article.edit', compact('article'));
    }

    public function update(Request $request,$id)
    {
        $article=Article::find($id);
        $validator = Validator::make(
        $request->all(),
        [
            'title' => 'required',
            'content' => 'required',
            'author' => 'required'
        ]
    );

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
        $article->title=$request->title;
        $article->content=$request->content;
        $article->author=$request->author;
        $article->update();
        return redirect()->route('article.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if (!$article->findOrFail($id)) {
            return redirect()->route('article.index')->with('error', 'Article not found');
        }
        $article->delete();
        return redirect()->route('article.index')->with('success', 'Article deleted successfully');
    }
}
