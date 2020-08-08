<?php

namespace App\Http\Controllers;
use App\Models\Headline;
use Illuminate\Http\Request;
use DB;
use App\Helpers\UserHelper;

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
        UserHelper::can(['admin', 'staff']);
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

    public function dashboard()
    {
        UserHelper::can(['admin', 'staff', 'bendahara']);
        $total_user = DB::table('pengurus')->count();
        $totaluang = DB::table('transaksi')->count();
        $totalfoto = DB::table('foto')->count();
        $totalvideo = DB::table('video')->count();
        $response = [
            'status'=>'success',
            'message'=>'Dashboard Data list',
            'data' => [
                'pengurus' => $total_user,
                'transaksi' => $totaluang,
                'foto' => $totalfoto,
                'video' => $totalvideo
            ]
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
        UserHelper::can(['admin', 'staff']);
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

    public function update($id, Request $request)
    {
        UserHelper::can(['admin', 'staff']);
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
        UserHelper::can(['admin', 'staff']);
        $head = Headline::find($id);
        $head->delete();
        if ($head) {
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