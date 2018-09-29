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
                $request->tag_id
            )->orderBy('created_at', 'DESC')
	            ->paginate(config('freeblog.items_per_page_paginator'))
	            ->appends('search', $request->search)
	            ->appends('category_id,', $request->category_id)
	            ->appends('tag_id,', $request->tag_id);
        
        $categories = Category::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('name', 'ASC')->get();

		return view('front.index')
            ->with('articles', $articles)
            ->with('categories', $categories)
            ->with('tags', $tags);
	}
}
