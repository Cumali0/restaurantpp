<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
// MenuController.php
    public function listForPreorder()
    {
        $menus = Menu::all();
        return view('preorder.menu_partial', compact('menus')); // sadece menü kartlarını içeren blade
    }

    public function index()
    {
        $menus = Menu::where('active', 1)->get();

        return view('index', compact('menus')); // resources/views/index.blade.php dosyasına gönderiyoruz
    }


}
