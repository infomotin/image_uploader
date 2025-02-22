<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    
    //index 
    public function index()
    {
        return view('images.index');
    }
    //show
    public function showimages()
    {   
        return Image::pluck('name')->toArray();
    }
    //store
    public function store(Request $request)
    {
        // return response()->json(['error' => 'File Size Limit Exceeded'], 500);
        // dd($request->all());
        //validate the image file
        if(!$request->hasFile('image')){
            return response()->json(['upload_file_not_found'], 400);
        }
       $request->validate([
           'image' => 'required|file|image|mimes:png,jpg,jpeg|max:2048',
           ]); //size in kb

        //save the file into storage
        $path =$request->file('image')->store('public/images');
        if(!$path){
            return response()->json(['file_not_saved'], 500);
        }
        $uploadedFile = $request->file('image');
        $filename = $uploadedFile->hashName();
        $extension = $uploadedFile->extension();
        $size = $uploadedFile->getSize();
        //create image model 
        $image = Image::create([
            'name' => $filename,
            'extension' => $extension,
            'size' => $size,

        ]);
        //return the image model back to frontend
        return $image->name;

    }
}
