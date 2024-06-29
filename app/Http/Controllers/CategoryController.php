<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class CategoryController extends Controller
{
    # Get All Category
    public function getCategory(){
        $data = DB::table('category')
                    ->orderBy('id', 'DESC')
                    ->whereNull('deleted_at')
                    ->get();

        return $data;
    }

    # Get All Category Name
    public function getCategoryOption(){
        $data = DB::table('category')
                    ->whereNull('deleted_at')
                    ->orderBy('id', 'DESC')
                    ->get();

        $new_data = array();
        for ($i = 0; $i < count($data); $i++) {
            $id =  $data[$i]->id;
            $name =  $data[$i]->name;


            array_push($new_data, [
                'code' => $id,
                'label' => $name,
            ]);

        }
        return $new_data;

        return $data;
    }

    # Insert Category
    public function insertCategory(Request $request){
        $check_category = DB::table('category')
                            ->where('name',$request->name)
                            ->first();

        if(!$check_category)
        {
            $data = DB::table('category')
                    ->insert([
                        'name'=>$request->name,
                    ]);

            return $data;
        }
        else
        {
            return ['error'=>'Category already exists.'];
        }
    }

    # Update Product
    public function updateCategory(Request $request){
        $data = DB::table('category')
                    ->where('id',$request->id)
                    ->update([
                        'name'=>$request->name,
                    ]);
        return $data;
    }

    # Delete Product
    public function deleteCategory(Request $request){
        $data = DB::table('category')
                    ->where('id',$request->id)
                    ->update([
                        'deleted_at'=>Carbon::now(),
                    ]);
        return $data;
    }
}
