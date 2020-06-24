<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Auth;
use Storage;

use App\File;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function deleteFile(Request $request)
    {
      if ($request->ajax()) {
        $file = File::find($request['id']);
        $file_path = storage_path("app/public/".$file['type'].'/'.$file['name']);
        if (File::exists($file_path)) {
          Storage::delete($file_path);
          $delete = File::find($request['id'])->delete();
          echo $delete;
        }
        else {
          echo "3456";
        }
      }
    }
}
