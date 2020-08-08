<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Helpers\UserHelper;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("login");
    }
 
    public function index(Request $request)
    {
        // $head = User::orderBy('created_at', 'DESC')->paginate(10);
        UserHelper::can(['admin']);
        $head = User::orderBy('created_at', 'DESC')->get();
        $response=[
            'status'=>'success',
            'message'=>'User Data list',
            'data' => $head,
        ];
        return response()->json($response, 200);
    }
  

    public function updateProfile(Request $request, $id)
    {
        UserHelper::can(['admin', 'staff', 'bendahara']);
        $user = User::where('email', $id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->telpon = $request->telpon;

        if($user->save()){
            $response=[
                'status'=>'success',
                'message'=>'User Update Profile Success',
                'code'=> 200
            ];
         } else {
            $response=[
                'status'=>'Failed',
                'message'=>'Failed Update Data',
                'code'=> 404
            ];
         }
        return response()->json($response, 200);
    }

    public function name($email)
    {
        UserHelper::can(['admin']);
        $user = User::where('email', $email);
        $response = [
            'status'=>'Show Data Success',
            'data' => $user
        ];
        return response()->json($response, 200);
    }

    public function show($id)
    {
        $head = User::where('id', $id)->orWhere('email', $id)->get();
        $response=[
            'status'=>'Show Data Success',
            'data' => $head,
        ];
        return response()->json($response, 200);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
    		'name'=>'required',
    		'email'=>'required|email',
    		'password'=>'required',
    		'telpon'=>'required',
    		'level'=>'required',
         ]);
        $user = User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
            'telpon'=>$request->input('telpon'),
            'level'=>$request->input('level'),
         ]);

         if($user){
            $response=[
                'status'=>'success',
                'message'=>'User created Success',
                'code'=> 200
            ];
         } else {
            $response=[
                'status'=>'Failed',
                'message'=>'Failed Inser Data',
                'code'=> 404
            ];
         }
        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
    		'name'=>'required',
    		'email'=>'required|email',
    		'telpon'=>'required',
    		'level'=>'required',
         ]);
         $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->telpon = $request->telpon;
        $user->level = $request->level;

        if($user->save()){
            $response=[
                'status'=>'success',
                'message'=>'User Update Success',
                'code'=> 200
            ];
         } else {
            $response=[
                'status'=>'Failed',
                'message'=>'Failed Inser Data',
                'code'=> 404
            ];
         }
        return response()->json($response, 200);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        if ($user) {
            $out  = [
                "message" => "success Delete data",
                "code"  => 200
            ];
        } else {
            $out  = [
                "message" => "failed_delete_data",
                "code"   => 404,
            ];
        }
        return response()->json($out, $out['code']);
    }
}