<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LangController extends Controller
{
    public function change(Request $request)
    {
        App::setLocale($request->lang);
        
        // tao 1 session co key la locale
        session()->put('locale', $request->lang);
  
        return redirect()->back();
    }
}
