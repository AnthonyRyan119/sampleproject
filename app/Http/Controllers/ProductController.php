<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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

            if($file_attachments)
            {
                foreach($file_attachments as $file)
                {
                    Storage::disk('public')->putFileAs('Upload_Images/'.$data, $file, $file->getClientOriginalName());
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
        $data = DB::table('product')
                    ->where('id',$request->id)
                    ->update([
                        'name'=>$request->name,
                        'category'=>$request->email,
                        'description'=>$request->username,
                        'date'=>$request->date,
                    ]);
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
}
