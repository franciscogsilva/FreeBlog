<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    private $title_page = 'Inicio CMS';
    private $menu_item = 1;

    public function index(){
        return view('admin.index')
            ->with('menu_item', $this->menu_item)
            ->with('title_page', $this->title_page);
    }

}