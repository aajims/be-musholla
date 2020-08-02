<?php

namespace App\Http\Controllers;
use App\Models\Headline;
use Illuminate\Http\Request;

class HeadlineController extends Controller
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
        $head = Headline::all();
        $response =[
            'status'=>'success',
            'message'=>'Healine news list',
            'data' => $head,
        ];
        return response()->json($response, 200);
    }

    public function list()
    {
        $head = Headline::where('status', 'visible')->get();
        $response=[
            'status'=>'success',
            'message'=>'Healine news list',
            'data' => $head,
        ];
        return response()->json($response, 200);
    }

    public function show($id)
    {
        $head = Headline::findOrFail($id);
        $response=[
            'status'=>'Show Data Success',
            'data' => $head,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
    		'title'=>'required',
    		'content'=>'required',
    		'status'=>'required'
         ]);
        
         $title = $request->input("title");
         $content = $request->input("content");
         $status = $request->input("status");
         $data = [
            'title'=> $title,
            'content'=> $content,
            'status'=> $status
         ];
         $insert = Headline::create($data);
            if ($insert) {
                $out  = [
                    "message" => "success_insert_data",
                    "results" => $data,
                    "code"  => 200
                ];
            } else {
                $out  = [
                    "message" => "failed_insert_data",
                    "results" => $data,
                    "code"   => 404,
                ];
            }
            return response()->json($out, $out['code']);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
    		'title'=>'required',
    		'content'=>'required',
    		'status'=>'required'
         ]);
         if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }
         $title = $request->input("title");
         $content = $request->input("content");
         $status = $request->input("status");
         $head = Headline::find($id);
         $data = [
            'title'=> $title,
            'content'=> $content,
            'status'=> $status
         ];
         $update = $post->update($data);
         if ($update) {
            $out  = [
                "message" => "success_update_data",
                "results" => $data,
                "code"  => 200
            ];
        } else {
            $out  = [
                "message" => "failed_update_data",
                "results" => $data,
                "code"   => 404,
            ];
        }
        return response()->json($out, $out['code']);
    }

    public function delete($id)
    {
        $head = Headline::find($id);
        if(!$head){
            $data = [
                "message" => "id not found",
            ];
        } else {
            $data = [
                "message" => "Delete Success"
            ];
        }
        return response()->json($data, 200, $head);
    }
}