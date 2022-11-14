<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FileUploadRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Auth;

class FileUploadingController extends Controller
{
    public function upload(FileUploadRequest $request){
        $response = [];
        try{
            $dir = getDirectory($request->file_type);

            if($dir == False){
                return common_response( __('messages.undefined_file_type'), False, 400, []);
            }else{
                $dir = str_replace("{uuid}",\Auth::user()->uuid,$dir);
            }


            $file = $request->file('file');

            if(!Storage::exists($dir)){
                Storage::makeDirectory($dir);
            }

            $fileName =  Storage::put($dir, $file);

            $response = File::create([
                'name'      =>$fileName,
                'path'      =>$dir,
                'extention' =>$file->getClientOriginalExtension(),
                'type'      =>$file->getMimeType(),
                'size'      =>$file->getSize(),
            ]);

            $message        = __('messages.file_uploaded');
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
