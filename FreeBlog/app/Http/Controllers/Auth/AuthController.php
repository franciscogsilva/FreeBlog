<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function verify($confirmation_code){		
        $errors = [];
		$user = User::where('confirmation_code', $confirmation_code)->first();
		if(!$user){
            $errors['referral_code'] = 'The referral code is not valid';
			return redirect('/')
            	->with('errors', collect($errors));
		}
		$user->confirmed_at = Carbon::now();
		$user->confirmation_code = null;
		$user->save();
		
		return redirect('/login')
        	->with('session_msg', '¡La cuenta del Usuario '.$user->name.', ha sido confirmada correctamente!');
	}
}
