<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Mail\PasswordUserEmail;
use App\User;
use App\UserType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;
use InterventionImage;
use Auth;

class UserController extends Controller
{

    private $menu_item = 2;
    private $title_page = 'Usuarios';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::search(
                $request->search,
                $request->user_type_id
            )->orderBy('name', 'ASC')
	            ->paginate(config('freeblog.items_per_page_paginator'))
	            ->appends('search', $request->search)
	            ->appends('user_type_id', $request->user_type_id);
        
        $userTypes = UserType::orderBy('name', 'ASC')->get();

        return view('admin.users.index')
            ->with('users', $users)
            ->with('userTypes', $userTypes)
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
    	$userTypes = UserType::orderBy('name', 'ASC')->get();

        return view('admin.users.create_edit')
            ->with('userTypes', $userTypes)
            ->with('title_page', 'Crear nuevo Usuario')
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
        $this->validate($request, $this->getValidationRules($request), $this->getValidationMessages($request));
        $this->validate($request, $this->getValidationEmailRule($request), $this->getValidationEmailMessage($request));
        
        if($request->file('image')){
            $rules = [
                'image' => 'image|mimes:jpg,jpeg,png'
            ];

            $this->validate($request, $rules);
        }

        $user = new User();
        $password_temp = str_random(8);
        $this->setUser($user, $request, $password_temp);
        $user->confirmation_code = str_random(100);
        $user->save();

        //Mail::to($user->email)->send(new VerificationEmail($user));
        //Mail::to($user->email)->send(new PasswordUserEmail($user, $password_temp));

        return redirect()->route('users.index')
            ->with('session_msg', 'Se ha creado correctamente el usuario');
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
        $user = $this->validateUser($id);
    	$userTypes = UserType::orderBy('name', 'ASC')->get();

        return view('admin.users.create_edit')
            ->with('user', $user)
            ->with('userTypes', $userTypes)
            ->with('title_page', 'Editar Usuario: '.$user->name)
            ->with('menu_item', $this->menu_item);
    }

    public function update(Request $request, $id){
		$user = $this->validateUser($id);
        $errorsBag = new MessageBag();
        if(Auth::user()->isAdmin()){
           $this->validate($request, $this->getValidationTypeRule($request), $this->getValidationTypeMessage($request));            
        }else{
            if(Auth::user()->id != $id){
                $errorsBag->add('El usuario que intenta editar no corresponde al usuario logeado');
                return back()
                    ->withInput()
                    ->with('errors', $errorsBag);
            }
        }   
        $this->validate($request, $this->getValidationRules($request), $this->getValidationMessages($request));            

		if($user->email != $request->email){
			$this->validate($request, $this->getValidationEmailRule($request), $this->getValidationEmailMessage($request));            
		}

		if($request->file('image')){
			$rules = [
			'image' => 'image|mimes:jpg,jpeg,png'
			];

			$this->validate($request, $rules);
		}

		$this->setUser($user, $request);

        if(Auth::user()->isAdmin()){
            return redirect()->route('users.index')
            ->with('session_msg', 'Se ha editado correctamente el usuario');
        }else{
            return redirect()->route('profile.edit', Auth::user()->id)
            ->with('session_msg', 'Se ha editado correctamente el perfil de usuario');
        }
    }

    private function setUser($user, $request, $generatedPassword=null){
        $user->name = $request->name;
        $user->email = $request->email;
        if($generatedPassword){
            $user->password = bcrypt($generatedPassword);
        }
        $user->description = $request->description;
        if(Auth::user()->isAdmin()){
            $user->user_type_id = $request->user_type_id;
        }
        $user->save();

        if($request->file('image')){
            if($user->image) {
                if(file_exists(public_path().str_replace(env('APP_URL'), '/', $user->image))){
                    unlink(public_path().str_replace(env('APP_URL'), '/', $user->image));
                    unlink(public_path().str_replace(env('APP_URL'), '/', $user->image_thumbnail));
                }
            }
            $file       =   $request->file('image');
            $nameImg    =   'FGSFreeBlog_user_'.$user->id.'_'.time().'.'.$file->getClientOriginalExtension();
            $path       =   public_path().'/img/users/';
            $file->move($path, $nameImg);

            $thumbnail = InterventionImage::make($path.$nameImg)->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            $nameImg_thumbnail = 'FGSFreeBlog_user_'.$user->id.'_'.time().'_thumbnail'.'.'.$file->getClientOriginalExtension();
            $thumbnail->save($path.$nameImg_thumbnail);

            $user->image = asset('/img/users/'.$nameImg);
            $user->image_thumbnail = asset('/img/users/'.$nameImg_thumbnail);
        }elseif(!$user->image){
            $user->image            =   asset('/img/system32/user_profile.png');
            $user->image_thumbnail  =   asset('/img/system32/user_profile.png');
        }

        return $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $type=false){
        $user = $this->validateUser($id);
        $user->delete();
        if(!$type){
            return redirect()->route('users.index')
                ->with('session_msg', 'El usuario se ha eliminado correctamente');
        }             
    }
    
    public function destroyMulti(Request $request){
        if(isset($request->items_to_delete)){
            foreach ($request->items_to_delete as $item) {
                $this->destroy($item, true);
            }            
            return redirect()->route('users.index')
                ->with('session_msg', 'Los usuarios, se han eliminado correctamente');
        }else{            
            return redirect()->route('users.index');
        }
    }

    private function getValidationEmailRule($request){
        return [
            'email' => 'required|email|unique:users'
        ];
    }

    private function getValidationEmailMessage($request){
        return [
            'email.required'    =>  'El email del Usuario es obligatorio',
            'email.email'       =>  'El campo email debe ser un Correo Electrónico',
            'email.unique'      =>  'El email ingresado ya se encuentra en uso'
        ];
    }

    private function getValidationTypeRule($request){
        return [
            'user_type_id'  =>  'required'
        ];
    }

    private function getValidationTypeMessage($request){
        return [
            'user_type_id.required'     =>  'El tipo de usuario es obligatorio'
        ];
    }

    private function getValidationRules($request){
        return [
            'name'          =>  'required|min:3'
        ];
    }

    private function getValidationMessages($request){
        return [
            'name.required'             =>  'El nombre del usuario es obligatorio',
            'name.min'                  =>  'El nombre del usuario debe contener al menos 3 caracteres.'
        ];
    }

    private function validateUser($id){
        try {
            $user = User::findOrFail($id);
        }catch (ModelNotFoundException $e){
        	$errorsBag = new MessageBag();
            $errorsBag->add('User with ID '.$id.' not found.');
            return back()
                ->withInput()
                ->with('errors', $errorsBag);
        }
        return $user;
    }
}
