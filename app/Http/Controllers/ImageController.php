<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use Termwind\Components\Dd;
use Illuminate\Support\Facades\File; 

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
        // dd($request->all());
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,gif,jpg,svg,ico',
        ]);
        // GetFileName
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

    // delete
    public function delete(Request $request){
        Image::where('id', $request->id)->delete();
        File::delete('images/' .$request->name);
        
    }
    // get Img by ID
    public function getImgById(Request $request){ 
        $img = Image::where('id', $request->id)->get();
        return $img;
    }
    // Update Image
    public function update(Request $request){
        $request->validate([
            'image_update' => 'required|image|mimes:jpeg,png,gif,jpg,svg,ico',
        ]);
        $filename = time().'.'.$request->image_update->extension();  
        $request->file('image_update')->move(public_path('images'), $filename);
        // tim img cu 
        $getImg = Image::find($request->id);
            // Xoa file trong Public trc khi cap nhat tren database
        File::delete('images/' .$getImg->name);
        $getImg -> name = $filename;
        $getImg -> file_path = $filename;
        $getImg-> save();

        return back();
    }
}
