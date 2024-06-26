<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Auth;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    { 
        // return $request->all();
        try {

            $email = $request->email;
            $password = $request->password;

            if($email && $password){
                //validate user in local db

                $result_email = User::where('email', $email)->first();

                if($result_email)
                {
                    $result_data = $result_email;
                }
                else
                {
                    $result_username = User::where('username', $email)->first();
                    
                    $result_username ? $result_data = $result_username : $result_data = [];
                }


                if ($result_data && Hash::check($password, $result_data->password)) {
                    //user is match
                    Auth::login($result_data);
                    return redirect('/');
                }
                else
                {
                    $errors = ['error'=>'Credentails not found. The email or password you entered is incorrect. Please try again.'];
                    return redirect('/login')->withErrors($errors);
                }

                
            }

        } catch (RequestException $e) {
            $errors = $e->getResponse();
            $errors = json_decode((string) $errors->getBody(), true);
            return redirect('/login')->withErrors($errors);
        }
    }

    # Get User information
    public function getUserInformation()
    {
        return Auth::user();
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('login');
    }
}
