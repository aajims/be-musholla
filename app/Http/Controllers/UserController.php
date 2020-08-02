<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("login");
    }
 
    public function index()
    {
        // $head = User::orderBy('created_at', 'DESC')->paginate(10);
        $head = User::orderBy('created_at', 'DESC')->get();
        $response=[
            'status'=>'success',
            'message'=>'User Data list',
            'data' => $head,
        ];
        return response()->json($response, 200);
    }

    public function show($id)
    {
        $head = User::findOrFail($id);
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
            'password'=>$request->input('password'),
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
    		'name'=>'name',
    		'email'=>'required|email',
    		'password'=>'required',
    		'telp'=>'required',
    		'level'=>'required',
         ]);
         $user = User::where('id',$id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'telp'=>$request->telp,
            'level'=>$request->level,
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

    public function delete($id)
    {
        $user = User::find($id);
        if(!$user){
            $data = [
                "message" => "id not found",
            ];
        } else {
            $data = [
                "message" => "Delete Success"
            ];
        }
        return response()->json($data, 200, $user);
    }
   
}