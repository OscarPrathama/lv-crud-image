<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MultipleUploadController extends Controller
{
    public function upload(ImageRequest $request){

        if($request->hasFile('post_image')) {

            $file = $request->file('post_image');

            $file_original_name = $file->getClientOriginalName();
            $raw_file_name = pathinfo($file_original_name, PATHINFO_FILENAME);
            $file_name = strtolower(str_replace(' ', '-', $raw_file_name));
            $file_type = $file->getClientMimeType();
            $file_ext = $file->getClientOriginalExtension();
            $file_size = $file->getSize();
            $folder = 'public/images';
            $final_file_name = $file_name.'.'.$file_ext;

            $post_image = $file->storeAs($folder, $final_file_name);
            
            $data = Image::create([
                'title' => $raw_file_name,
                'path' => $post_image
            ]);

            return response($data, Response::HTTP_CREATED);
        }
        
    }

    public function multipleUpload(){
        
    }

}
