<?php

namespace App\Http\Controllers\Cms;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Auth;

class CategoryController extends Controller
{
    private $menu_item = 3;
    private $title_page = 'Categorias';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $categories = Category::search(
            $request->name
        )->orderBy('created_at', 'DESC')
            ->paginate(config('prestamosjdc.items_per_page_paginator'))
            ->appends('name', $request->name);

        return view('admin.categories.index')
            ->with('categories', $categories)
            ->with('title_page', $this->title_page)
            ->with('menu_item', $this->menu_item);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.categories.create_edit')
            ->with('title_page', 'Crear nueva Categoria')
            ->with('menu_item', $this->menu_item);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $this->validate($request, $this->getValidationRules($request), $this->getValidationMessages($request));

        $category = new Category();
        $this->setCategory($category, $request);

        return redirect()->route('categories.index')
            ->with('session_msg', '¡La nueva Categoria, se ha creado correctamente!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $category = $this->validateCategory($id);
        $this->validateUserPerm($category);

        return view('admin.categories.create_edit')
            ->with('category', $category)
            ->with('title_page', 'Editar Categoria: '.$category->name)
            ->with('menu_item', $this->menu_item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $this->validate($request, $this->getValidationRules($request), $this->getValidationMessages($request));
        $category = $this->validateCategory($id);
        $this->validateUserPerm($category);
        $this->setCategory($category, $request);

        return redirect()->route('categories.index')
            ->with('session_msg', '¡La Categoria, se ha editado correctamente!');
    }

    private function validateUserPerm($resource){        
        if(!Auth::user()->isAdmin()){
            $errorsBag = new MessageBag();
            $errorsBag->add('Acción no permitida.');
            return back()
                ->withInput()
                ->with('errors', $errorsBag);
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $type=false){
        $this->validateUserPerm($category);
        $category = $this->validateCategory($id);
        $category->delete();
        if(!$type){
            return redirect()->route('categories.index')
                ->with('session_msg', 'La Categoria se ha eliminado correctamente');
        }             
    }
    
    public function destroyMulti(Request $request){
        if(isset($request->items_to_delete)){
            foreach ($request->items_to_delete as $item) {
                $this->destroy($item, true);
            }            
            return redirect()->route('categories.index')
                ->with('session_msg', 'Las Categorias, se han eliminado correctamente');
        }else{            
            return redirect()->route('categories.index');
        }
    }

    private function setCategory($category, $request){
        $category->name = $request->name;
        $category->icon = $request->icon;
        return $category->save();
    }

    private function getValidationRules($request){
        return [
            'name' => 'required|min:3'
        ];
    }

    private function getValidationMessages($request){
        return [
            'name.required' => 'El nombre de la Categoria es obligatorio',
            'name.min' => 'El nombre de la Categoria debe contener al menos 3 caracteres.'
        ];
    }

    private function validateCategory($id){
        try {
            $category = Category::findOrFail($id);            
        }catch (ModelNotFoundException $e){
            $errorsBag = new MessageBag();
            $errorsBag->add('Category with ID '.$id.' not found.');
            return back()
                ->withInput()
                ->with('errors', $errorsBag);
        }
        return $category;
    }
}
