<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    # Get All Users
    public function getUsers(){
        $users = new User;
        $users = $users->getUsers();
        return $users;
    }

    # Insert User
    public function insertUser(Request $request){
        $check_user = DB::table('users')
                            ->where('email',$request->email)
                            ->orWhere('username', $request->username)
                            ->first();

        if(!$check_user)
        {
            $data = DB::table('users')
                    ->insert([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'username'=>$request->username,
                        'password'=>Hash::make($request->password),
                        'role'=>$request->role,
                    ]);

            return $data;
        }
        else
        {
            return ['error'=>'User already exists.'];
        }
    }

    # Update User
    public function updateUser(Request $request){
        $check_user = DB::table('users')
                            ->where('name',$request->name)
                            ->orWhere('username', $request->username)
                            ->first();
        //check if user exist
        if(!$check_user)
        {
            $data = DB::table('users')
                    ->where('id',$request->id)
                    ->update([
                        'name'=> $request->name,
                        'email'=> $request->email,
                        'username'=> $request->username,
                        'role'=> $request->role
                    ]);

            return $data;
        }
        else if($check_user)
        {
            //check if match name or username is from the same user
            if($check_user->id == $request->id)
            {
                $data = DB::table('users')
                    ->where('id',$request->id)
                    ->update([
                        'name'=> $request->name,
                        'email'=> $request->email,
                        'username'=> $request->username,
                        'role'=> $request->role
                    ]);

                return $data;
            }
            else
            {
                return ['error'=>'Inserted name or username is already taken.'];
            }
            
        }
        
    }

    # Delete User
    public function deleteUser(Request $request){
        $data = DB::table('users')
                    ->where('id',$request->id)
                    ->update([
                        'deleted_at'=>Carbon::now(),
                    ]);
        return $data;
    }

    
}
