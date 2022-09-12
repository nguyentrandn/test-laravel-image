<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use Termwind\Components\Dd;

class ImageController extends Controller
{
    public function index(){
        return view('imageUpload');
    }
    public function getImg(){
        $imgs = Image::get();

        // Cach 1
        // return view('imageUpload', compact('imgs'));

        // Cach 2
        return view('imageUpload')->with('imgs', $imgs);
    }

    public function store(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,gif,jpg,svg,ico',
        ]);
        // Get FileName
        $filename = time().'.'.$request->image->extension();  
        // move file to Public/images folder
        $request->file('image')->move(public_path('images'), $filename);
        $image = new Image([
            'name' => $filename,
            'file_path' => $filename
        ]);
        $image->save();

        return back()
            ->with('success', 'You have successfully uploaded your image.')
            ->with('image', $filename);
    }
}
