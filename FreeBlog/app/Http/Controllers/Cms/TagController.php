<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $menu_item = 4;
    private $title_page = 'Tags';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $tags = Tag::search(
            $request->name
        )->orderBy('created_at', 'DESC')
            ->paginate(config('prestamosjdc.items_per_page_paginator'))
            ->appends('name', $request->name);

        return view('admin.tags.index')
            ->with('tags', $tags)
            ->with('title_page', $this->title_page)
            ->with('menu_item', $this->menu_item);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.tags.create_edit')
            ->with('title_page', 'Crear nueva Tag')
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

        $tag = new Tag();
        $this->setTag($tag, $request);

        return redirect()->route('tags.index')
            ->with('session_msg', '¡El nuevo Tag, se ha creado correctamente!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $tag = $this->validateTag($id);

        return view('admin.tags.create_edit')
            ->with('tag', $tag)
            ->with('title_page', 'Editar Tag: '.$tag->name)
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
        $tag = $this->validateTag($id);
        $this->setTag($tag, $request);

        return redirect()->route('tags.index')
            ->with('session_msg', '¡El Tag, se ha editado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $type=false){
        $tag = $this->validateTag($id);
        $tag->delete();
        if(!$type){
            return redirect()->route('tags.index')
                ->with('session_msg', 'El Tag se ha eliminado correctamente');
        }             
    }
    
    public function destroyMulti(Request $request){
        if(isset($request->items_to_delete)){
            foreach ($request->items_to_delete as $item) {
                $this->destroy($item, true);
            }            
            return redirect()->route('tags.index')
                ->with('session_msg', 'Los Tags, se han eliminado correctamente');
        }else{            
            return redirect()->route('tags.index');
        }
    }

    private function setTag($tag, $request){
        $tag->name = $request->name;
        return $tag->save();
    }

    private function getValidationRules($request){
        return [
            'name' => 'required|min:3'
        ];
    }

    private function getValidationMessages($request){
        return [
            'name.required' => 'El nombre de la Tag es obligatorio',
            'name.min' => 'El nombre de la Tag debe contener al menos 3 caracteres.'
        ];
    }

    private function validateTag($id){
        try {
            $tag = Tag::findOrFail($id);            
        }catch (ModelNotFoundException $e){
            $errorsBag = new MessageBag();
            $errorsBag->add('Article with ID '.$id.' not found.');
            return back()
                ->withInput()
                ->with('errors', $errorsBag);
        }
        return $tag;
    }
}
