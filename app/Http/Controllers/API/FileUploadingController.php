<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FileUploadRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Exception;

class FileUploadingController extends Controller
{
    public function upload(FileUploadRequest $request){
        $response = [];
        try{
            $file = $request->file('file');

            if(!Storage::exists($request->path)){
                Storage::makeDirectory($request->path);
            }

            $fileName =  Storage::put($request->path, $file);

            $response = File::create([
                'name'      =>$fileName,
                'path'      =>$request->path,
                'extention' =>$file->getClientOriginalExtension(),
                'type'      =>$file->getMimeType(),
                'size'      =>$file->getSize(),
            ]);

            $message        = 'File has been Uploaded';
            $status_code    = 200;
            $status         =  True;

        } catch (Exception $e) {

            $message        = $e->getMessage();
            $status_code    = $e->getCode();
            $status         =   False;
        }

        return common_response( $message, $status, $status_code, $response );
    }



}
