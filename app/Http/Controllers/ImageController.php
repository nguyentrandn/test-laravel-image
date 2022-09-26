<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ImageController extends Controller
{
    // Handle khi nguoi dung ko dang nhap
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    // End handle
    public function index()
    {
        return view('imageUpload');
    }
    public function getImg()
    {
        // sap xep theo ngay them
        // $imgs = Image::orderBy('created_at', 'DESC')->get();

        // phan trang
        $imgs = Image::orderBy('created_at', 'DESC')->paginate(15);


        // Cach 1
        // return view('imageUpload', compact('imgs'));

        // Cach 2
        return view('imageUpload')->with('imgs', $imgs);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'image' => 'required|image|mimes:jpeg,png,gif,jpg,svg,ico',
        ]);
        $imagesName = [];
        foreach ($request->image as  $value) {
            // GetFileName
            $filename = time() . rand(1, 99) . '.' . $value->extension();
            // move file to Public/images folder
            $value->move(public_path('images'), $filename);

            // dua tat ca Name vao 1 mang
            $imagesName[]['name'] = $filename;
        }
        // dd($imagesName);
        foreach ($imagesName as $imageName) {
            // dd($imageName);
            Image::create($imageName);
        }

        return back()
            ->with('success', 'You have successfully uploaded your image.');
    }

    // delete
    public function delete(Request $request)
    {

        Image::where('id', $request->id)->delete();
        File::delete('images/' . $request->name);
    }
    // get Img by ID
    public function getImgById(Request $request)
    {
        $img = Image::where('id', $request->id)->get();
        return $img;
    }
    // Update Image
    public function update(Request $request)
    {
        $request->validate([
            'image_update' => 'required|image|mimes:jpeg,png,gif,jpg,svg,ico',
        ]);
        $filename = time() . '.' . $request->image_update->extension();
        $request->file('image_update')->move(public_path('images'), $filename);
        // tim img cu 
        $getImg = Image::find($request->id);
        // Xoa file trong Public trc khi cap nhat tren database
        File::delete('images/' . $getImg->name);
        $getImg->name = $filename;
        $getImg->save();

        return back();
    }
}
