<?php

namespace App\Http\Controllers;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware("login");
    }

    public function index()
    {
        UserHelper::can(['admin', 'staff']);
        $photo = Video::all();
        $response=[
            'status'=>'success',
            'message'=>'Video list',
            'data' => $photo,
        ];
        return response()->json($response, 200);
    }

    public function list()
    {
        $photo = Video::all();
        $response=[
            'status'=>'success',
            'message'=>'Video list',
            'data' => $photo,
        ];
        return response()->json($response, 200);
    }

    public function create(Request $request)
    {
        UserHelper::can(['admin', 'staff']);
        $photo = Video::create([
            'name'=>$request->input('name'),
            'link'=>$request->input('link'),
            'caption'=>$request->input('caption')
         ]);

         $response=[
            'status'=>'success',
            'message'=>'Video created Success',
        ];

        return response()->json($response, 200);
    }

    public function show($id)
    {
        UserHelper::can(['admin', 'staff']);
        $photo = Video::findOrFail($id);
        $response=[
            'status'=>'success',
            'data' => $photo,
        ];
        return response()->json($response, 200);
    }

    public function update(Request $request ,$id)
    {
        UserHelper::can(['admin', 'staff']);
        $photo = Video::findOrFail($id);
        $photo->update($request->all());
         $response=[
            'status'=>'success',
            'message' => 'Updated Sucess',
            'data' =>$photo,
        ];
        return response()->json($response, 200);
    }

    public function delete($id)
    {
        UserHelper::can(['admin', 'staff']);
        $photo = Video::findOrFail($id);
        $photo->delete();
        $response=[
            'status'=>'success',
            'message' => 'Deleted Success',
            "code"  => 200
        ];
        return response()->json($response, 200);
    }
}
