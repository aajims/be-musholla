<?php

namespace App\Http\Controllers;
use App\Models\Penasehat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Helpers\UserHelper;

class PenasehatController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware("login");
        UserHelper::can(['admin', 'staff']);
    }

    public function index() {
        return response()->json([
            'status'  => 'success',
            'message' => 'Penasehat list',
            'data'    => Penasehat::all(),
        ], 200);
    }

    public function list() {
        // return response()->json([
        //     'status'  => 'success',
        //     'message' => 'Penasehat visible list',
        //     'data'    => Penasehat::where('status', 'visible')->get(),
        // ], 200);
    }

    public function show($id) {
        return response()->json([
            'status'  => 'success',
            'message' => 'Penasehat visible list',
            'data'    => Penasehat::findOrFail($id),
        ], 200);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'nama'    => 'required',
            'jabatan' => 'required'
        ]);
        if ( ! $request->hasFile('foto')) {
            $this->validate($request, [
                'foto' => 'required'
            ]);
        }

        $picName = str_slug($request->nama) . '.' . $request->file('foto')->getClientOriginalExtension();
        $picName = Carbon::now()->timestamp . '-' . $picName;
        $destinationPath = 'assets/img/Penasehat/' . $picName;
        $img = Image::make($request->file('foto'));
        $img->resize(145, 140);
        $img->save($destinationPath);

        $Penasehat = new Penasehat;
        $Penasehat->nama = $request->nama;
        $Penasehat->foto = $destinationPath;
        $Penasehat->jabatan = $request->jabatan;
        if ($Penasehat->save()) {
            $out  = [
                "message" => "success_insert_data",
                "code"  => 200
            ];
        } else {
            $out  = [
                "message" => "failed_insert_data",
                "code"   => 404,
            ];
        }
        return response()->json($out, $out['code']);
    }

    public function update($id, Request $request) {
        $this->validate($request, [
            'nama'    => 'required',
            'jabatan' => 'required'
        ]);
        $Penasehat = Penasehat::findOrFail($id);

        if ($request->hasFile('foto')) {
            $picName = str_slug($request->nama) . '.' . $request->file('foto')->getClientOriginalExtension();
            $picName = Carbon::now()->timestamp . '-' . $picName;
            $destinationPath = 'assets/img/Penasehat/' . $picName;
            $img = Image::make($request->file('foto'));
            $img->resize(145, 140);
            $img->save($destinationPath);
            unlink(base_path($Penasehat->foto));
            $Penasehat->foto = $destinationPath;
        }

        $Penasehat->nama = $request->nama;
        $Penasehat->jabatan = $request->jabatan;
        if ($Penasehat->save()) {
            $out  = [
                "message" => "success_update_data",
                "code"  => 200
            ];
        } else {
            $out  = [
                "message" => "failed_update_data",
                "code"   => 404,
            ];
        }
        return response()->json($out, $out['code']);
    }

    public function delete($id) {
        $Penasehat = Penasehat::find($id);
        $Penasehat->delete();
        if ($Penasehat) {
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
