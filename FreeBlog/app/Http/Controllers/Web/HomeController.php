<?php

namespace App\Http\Controllers\Web;

use App\Article;
use App\Category;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index(Request $request){
		$articles = Article::where('article_status_id', 1)
			->search(
                $request->search,
                $request->category_id,
                $request->tag_id,
                $request->user_id
            )->orderBy('created_at', 'DESC')
	            ->paginate(config('freeblog.items_per_page_paginator'))
	            ->appends('search', $request->search)
	            ->appends('category_id,', $request->category_id)
                ->appends('tag_id,', $request->tag_id)
	            ->appends('user_id,', $request->user_id);
        
        $popularArticles = Article::orderBy('views', 'DESC')->take(5)->get();
        $categories = Category::inRandomOrder()->take(10)->get();
        $tags = Tag::inRandomOrder()->take(10)->get();

		return view('front.index')
            ->with('articles', $articles)
            ->with('popularArticles', $popularArticles)
            ->with('categories', $categories)
            ->with('tags', $tags);
	}
}
