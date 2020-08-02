<?php

namespace App\Http\Controllers;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $uang = Keuangan::orderBy('created_at', 'DESC')->get();
        $response=[
            'status'=>'success',
            'message'=>'Keuangan list',
            'data' => $uang,
        ];

        return response()->json($response, 200);
    }

    public function list()
    {
        $uang = Keuangan::orderBy('created_at', 'DESC')->get();
        $response=[
            'status'=>'success',
            'message'=>'Keuangan list',
            'data' => $uang,
        ];

        return response()->json($response, 200);
    }

    public function show($id)
    {
        $uang = Keuangan::findOrFail($id);
        $response=[
            'status'=>'success',
            'data' => $uang,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
    		'tanggal'=>'required',
    		'uraian'=>'required',
    		'seksi'=>'required',
    		'keterangan'=>'required',
         ]);
         
        $uang = Keuangan::create([
            'tanggal'=>$request->input('tanggal'),
            'uraian'=>$request->input('uraian'),
            'pemasukan'=>(int)$request->input('pemasukan'),
            'pengeluaran'=>(int)$request->input('pengeluaran'),
            'seksi'=>$request->input('seksi'),
            'keterangan'=>$request->input('keterangan'),
         ]);

         if($uang){
            $response=[
                'status'=>'success',
                'message'=>'Keuangan created Success',
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
    		'tanggal'=>'required',
    		'uraian'=>'required',
    		'seksi'=>'required',
    		'keterangan'=>'required',
         ]);

        $uang = Keuangan::where('id_trans',$id)->update([
            'tanggal'=>$request->tanggal,
            'uraian'=>$request->uraian,
            'pemasukan'=>(int)$request->pemasukan,
            'pengeluaran'=>(int)$request->pengeluaran,
            'seksi'=>$request->seksi,
            'keterangan'=>$request->keterangan,
        ]);
    	if($uang){
            $response=[
                'status'=>'success',
                'message'=>'Update Data Success',
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

    public function delete($id)
    {
        $head = Keuangan::find($id);
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
