<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    # Get All Product
    public function getProduct(){
        $data = DB::table('product')
                    ->orderBy('id', 'DESC')
                    ->whereNull('deleted_at')
                    ->get();

        return $data;
    }

    # Insert Product
    public function insertProduct(Request $request){
        $check_product = DB::table('product')
                            ->where('name',$request->name)
                            ->where('category', $request->category)
                            ->where('description', $request->description)
                            ->first();

        $file_attachments = $request->file_attachments;

        if(!$check_product)
        {
            $data = DB::table('product')
                        ->insertGetID([
                            'name'=>$request->name,
                            'category'=>$request->category,
                            'description'=>$request->description,
                            'date'=>$request->date,
                        ]);
            
            $i = 0;
            if($file_attachments)
            {
                foreach($file_attachments as $file)
                {
                    $i++;
                    $fileName = $data .'-'. $i . '.png';
                    Storage::disk('public')->putFileAs('Upload_Images/'.$data, $file, $fileName);
                }
            }

            return 'success';
        }
        else
        {
            return ['error'=>'Product already exists.'];
        }
    }

    # Update Product
    public function updateProduct(Request $request){
        $file_attachments = $request->file_attachments;
        $data = DB::table('product')
                    ->where('id',$request->id)
                    ->update([
                        'name'=>$request->name,
                        'category'=>$request->category,
                        'description'=>$request->description,
                        'date'=>$request->date,
                    ]);


        //remove existing images
        $folderToDelete = 'storage/Upload_Images/'.$request->id;

        if (File::exists(public_path($folderToDelete))) 
        {
            File::deleteDirectory(public_path($folderToDelete));
        }

        //insert new images
        $id = $request->id;
        $i = 0;
        if($file_attachments)
        {
            foreach($file_attachments as $file)
            {
                $i++;
                $fileName = $data .'-'. $i . '.png';
                Storage::disk('public')->putFileAs('Upload_Images/'.$id, $file, $file->getClientOriginalName());
            }
        }
        return $data;
        
        
    }

    # Delete Product
    public function deleteProduct(Request $request){
        $data = DB::table('product')
                    ->where('id',$request->id)
                    ->update([
                        'deleted_at'=>Carbon::now(),
                    ]);
        return $data;
    }

    # View File Attachment
    public function viewFileAttachment(Request $request)
    {
        $id = $request->id;

        $files = array();
        $file_path = 'Upload_Images/'.$id;
        $file = Storage::disk('public')->files($file_path);
        return $file;
    }

    public function filterCategory(Request $request)
    {
        $data = DB::table('product')
                    ->orderBy('id', 'DESC')
                    ->whereNull('deleted_at')
                    ->where('category',$request->category)
                    ->get();

        return $data;
    }

}
