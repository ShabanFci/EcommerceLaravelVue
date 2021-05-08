<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Validator;

class UserController extends Controller
{
    public function index(){

    	return response()->json(User::With('orders')->Where('is_admin',0)->paginate(10));
    }

    public function login(Request $request)
        {
            $status = 401;
            $response = ['credentials' => 'These Credentials Does Not Exist '];

            $this->validate($request ,  [
                
                'email'    => 'required|max:255|email|exists:users',
                'password' => 'required',
                
                
            ]);
            
            if (Auth::attempt($request->only(['email', 'password']))) {
                $status = 200;
                $response = [
                    'user' => Auth::user(),
                    'token' => Auth::user()->createToken('loggedUserToken')->accessToken,
                ];
            }
            
            return response()->json($response, $status);
        }

    public function register(Request $request)
        {

            $this->validate($request ,  [
                'name' => 'required|max:50',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'c_password' => 'required|same:password',
            ]);


            $data = $request->only(['name', 'email', 'password']);
            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);
            $user->is_admin = 0;

            return response()->json([
                'user' => $user,
                'token' => $user->createToken('loggedUserToken')->accessToken,
            ]);
        }

    public function show(User $user){

    	return response()->json($user);
    }

    public function showOrders(User $user){

    	return response()->json($user->orders()->With('product')->orderBy('id','DESC')->paginate(4));
    }
    
    /* admin Showing The User Orders */
    public function userOrders(User $user){

        return response()->json($user->orders()->With('product')->orderBy('id','DESC')->get());
    }


}
