<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    private $title_page = 'Inicio CMS';
    private $menu_item = 0;

    public function index(){
        return redirect()->route('articles.index');
    }

}