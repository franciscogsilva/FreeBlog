<?php

namespace App\Http\Controllers\Web;

use App\Article;
use App\Category;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    private $menu_item = 1;
    private $title_page = 'Articulos';

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($slug){
        try {
            $article = Article::where('slug', $slug)->first();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('welcome')
                ->with('session_msg', '¡La noticia no existe!');            
        }
        
        $popularArticles = Article::orderBy('views', 'DESC')->take(5)->get();
        $categories = Category::inRandomOrder()->take(10)->get();
        $tags = Tag::inRandomOrder()->take(10)->get();

        return view('front.articles.show')
            ->with('article', $article)
            ->with('popularArticles', $popularArticles)
            ->with('categories', $categories)
            ->with('tags', $tags)
            ->with('title_page', env('APP_NAME').' - '.$article->title)
            ->with('menu_item', $this->menu_item);            
    }
}
