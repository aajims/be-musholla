<?php

namespace App\Http\Controllers;
use App\Models\Foto;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // UserHelper::can(['admin', 'staff']);
    }

    public function index()
    {
        UserHelper::can(['admin', 'staff']);
        $photo = Foto::all();
        $response=[
            'status'=>'success',
            'message'=>'Foto list',
            'data' => $photo,
        ];
        return response()->json($response, 200);
    }

    public function list()
    {
        $photo = Foto::all();
        $response=[
            'status'=>'success',
            'message'=>'Foto list',
            'data' => $photo,
        ];
        return response()->json($response, 200);
    }

    public function create(Request $request)
    {
        UserHelper::can(['admin', 'staff']);
        $photo = Foto::create([
            'name'=>$request->input('name'),
            'link'=>$request->input('link'),
            'caption'=>$request->input('caption')
         ]);

         $response=[
            'status'=>'success',
            'message'=>'Foto created Success',
        ];

        return response()->json($response, 200);
    }

    public function show($id)
    {
        $photo = Foto::findOrFail($id);
        $response=[
            'status'=>'success',
            'data' => $photo,
        ];
        return response()->json($response, 200);
    }

    public function update(Request $request ,$id)
    {
        UserHelper::can(['admin', 'staff']);
        $photo = Foto::findOrFail($id);
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
        $photo = Foto::findOrFail($id);
        $photo->delete();
        $response=[
            'status'=>'success',
            'message' => 'Deleted Success',
            "code"  => 200
        ];
        return response()->json($response, 200);
    }
}
