<?php

namespace App\Http\Controllers\Cms;

use App\Article;
use App\ArticleStatus;
use App\Category;
use App\Http\Controllers\Controller;
use App\Image;
use App\Tag;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use InterventionImage;

class ArticleController extends Controller
{

    private $menu_item = 1;
    private $title_page = 'Articulos';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = Article::search(
                $request->search,
                $request->category_id,
                $request->tag_id,
                $request->article_status_id
            )->orderBy('created_at', 'DESC')
	            ->paginate(config('freeblog.items_per_page_paginator'))
	            ->appends('search', $request->search)
	            ->appends('category_id,', $request->category_id)
	            ->appends('tag_id,', $request->tag_id)
	            ->appends('article_status_id,', $request->article_status_id);
        
        $categories = Category::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('name', 'ASC')->get();
        $articleStatuses = ArticleStatus::orderBy('name', 'ASC')->get();

        return view('admin.articles.index')
            ->with('articles', $articles)
            ->with('categories', $categories)
            ->with('tags', $tags)
            ->with('articleStatuses', $articleStatuses)
            ->with('title_page', $this->title_page)
            ->with('menu_item', $this->menu_item);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $categories = Category::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('name', 'ASC')->get();
        $articleStatuses = ArticleStatus::orderBy('name', 'ASC')->get();
        $users = User::orderBy('name', 'ASC')->get();

        return view('admin.articles.create_edit')
            ->with('categories', $categories)
            ->with('tags', $tags)
            ->with('articleStatuses', $articleStatuses)
            ->with('users', $users)
            ->with('title_page', 'Crear nuevo Articulo')
            ->with('menu_item', $this->menu_item);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->getValidationRulesTitle($request), $this->getValidationTitleMessages($request));
        $this->validate($request, $this->getValidationRules($request), $this->getValidationMessages($request));
        
        if($request->file('image')){
            $rules = [
                'image' => 'image|mimes:jpg,jpeg,png'
            ];

            $this->validate($request, $rules);
        }

        $article = new Article();
        $this->setArticle($article, $request);
        $article->categories()->attach($request->categories);
        $article->tags()->attach($request->tags);

        return redirect()->route('articles.index')
            ->with('session_msg', 'Se ha creado correctamente el Articulo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $article = $this->validateArticle($id);        
        $categories = Category::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('name', 'ASC')->get();
        $articleStatuses = ArticleStatus::orderBy('name', 'ASC')->get();
        $users = User::orderBy('name', 'ASC')->get();

        return view('admin.articles.create_edit')
            ->with('article', $article)
            ->with('categories', $categories)
            ->with('tags', $tags)
            ->with('articleStatuses', $articleStatuses)
            ->with('users', $users)
            ->with('title_page', 'Editar Articulo: '.$article->title)
            ->with('menu_item', $this->menu_item);
    }

    public function update(Request $request, $id){
		$article = $this->validateArticle($id);
		if($article->title != $request->title){
        	$this->validate($request, $this->getValidationRulesTitle($request), $this->getValidationTitleMessages($request));
		}
		$this->validate($request, $this->getValidationRules($request), $this->getValidationMessages($request));

		if($request->file('image')){
			$rules = [
			'image' => 'image|mimes:jpg,jpeg,png'
			];

			$this->validate($request, $rules);
		}

		$this->setArticle($article, $request);
        $article->categories()->detach();
        $article->tags()->detach();
        $article->categories()->attach($request->categories);
        $article->tags()->attach($request->tags);

        return redirect()->route('articles.index')
            ->with('session_msg', 'Se ha editado correctamente el Articulo');
    }

    private function setArticle($article, $request){
        $article->title = $request->title;
        $article->slug = Str::slug($request->title);
        $article->content = $request->content;
        $article->description = $request->description;
        $article->user_id = $request->user_id;
        $article->article_status_id = $request->article_status_id;        
        $article->save();

        if($request->file('image')){
            if(isset($article->image)) {
                if(file_exists(public_path().str_replace(env('APP_URL'), '/', $article->image))){
                    unlink(public_path().str_replace(env('APP_URL'), '/', $article->image));
                    unlink(public_path().str_replace(env('APP_URL'), '/', $article->image_thumbnail));
                }
            }
            $file       =   $request->file('image');
            $nameImg    =   'FGSFreeBlog_article_'.$article->id.'_'.time().'.'.$file->getClientOriginalExtension();
            $path       =   public_path().'/img/articles/';
            $file->move($path, $nameImg);

            $thumbnail = InterventionImage::make($path.$nameImg)->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            $nameImg_thumbnail = 'FGSFreeBlog_article_'.$article->id.'_'.time().'_thumbnail'.'.'.$file->getClientOriginalExtension();
            $thumbnail->save($path.$nameImg_thumbnail);

            $newImage = new Image();
            $newImage->image = asset('/img/articles/'.$nameImg);
            $newImage->image_thumbnail = asset('/img/articles/'.$nameImg_thumbnail);
            $newImage->save();
            $article->image_id = $newImage->id;
        }elseif(!$article->image){
            $article->image_id = 1;
        }

        return $article->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $type=false){
        $article = $this->validateArticle($id);
        $article->delete();
        if(!$type){
            return redirect()->route('articles.index')
                ->with('session_msg', 'El Articulo se ha eliminado correctamente');
        }             
    }
    
    public function destroyMulti(Request $request){
        if(isset($request->items_to_delete)){
            foreach ($request->items_to_delete as $item) {
                $this->destroy($item, true);
            }            
            return redirect()->route('articles.index')
                ->with('session_msg', 'Los Articulos, se han eliminado correctamente');
        }else{            
            return redirect()->route('articles.index');
        }
    }

    private function getValidationRulesTitle($request){
    	return [    		
        	'title' => 'required|min:3|unique:articles'
    	];
    }

    private function getValidationTitleMessages($request){
    	return [    		
            'title.required' => 'El titulo del Articulo es obligatorio',
            'title.min' => 'El titulo del Articulo debe contener al menos 3 caracteres.',
            'title.unique' => 'El titulo del Articulo debe ser único.',
    	];
    }

    private function getValidationRules($request){
        return [
            'content' => 'required|min:50',
            'description' => 'required|min:10',
            'user_id' => 'required',
            'article_status_id' => 'required',
            'categories' => 'required',
            'tags' => 'required',
        ];
    }

    private function getValidationMessages($request){
        return [
            'content.required' => 'El contenido del Articulo es obligatorio',
            'content.min' => 'El contenido del Articulo debe contener al menos 50 caracteres.',
            'description.required' => 'La descripción del Articulo es obligatorio',
            'description.min' => 'La descripción del Articulo debe contener al menos 10 caracteres.',
            'user_id.required' => 'El Autor del Articulo es obligatorio',
            'article_status_id.required' => 'Es estado del Articulo es obligatorio',
            'categories.required' => 'La o las Categorias del Articulo es obligatorio',
            'tags.required' => 'El o los Tags del Articulo es obligatorio'
        ];
    }

    private function validateArticle($id){
        try {
            $Article = Article::findOrFail($id);
        }catch (ModelNotFoundException $e){
        	$errorsBag = new MessageBag();
            $errorsBag->add('Article with ID '.$id.' not found.');
            return back()
                ->withInput()
                ->with('errors', $errorsBag);
        }
        return $Article;
    }
}
