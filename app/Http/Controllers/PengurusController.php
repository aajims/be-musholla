<?php

namespace App\Http\Controllers;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class pengurusController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware("login");
        UserHelper::can(['admin', 'bendahara']);
    }
    
    public function index() {
        return response()->json([
            'status'  => 'success',
            'message' => 'Pengurus list',
            'data'    => Pengurus::all(),
        ], 200);
    }

    public function list() {
        // return response()->json([
        //     'status'  => 'success',
        //     'message' => 'Pengurus data list',
        //     'data'    => Pengurus::where('status', 'visible')->get(),
        // ], 200);
    }

    public function show($id) {
        return response()->json([
            'status'  => 'success',
            'message' => 'Pengurus visible list',
            'data'    => Pengurus::findOrFail($id),
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
        $destinationPath = 'assets/img/pengurus/' . $picName;
        $img = Image::make($request->file('foto'));
        $img->resize(145, 140);
        $img->save($destinationPath . $picName);

        $pengurus = new Pengurus;
        $pengurus->nama = $request->nama;
        $pengurus->foto = $destinationPath;
        $pengurus->jabatan = $request->jabatan;
        if ($pengurus->save()) {
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
        $pengurus = Pengurus::findOrFail($id);

        if ($request->hasFile('foto')) {
            $picName = str_slug($request->nama) . '.' . $request->file('foto')->getClientOriginalExtension();
            $picName = Carbon::now()->timestamp . '-' . $picName;
            $destinationPath = 'assets/img/pengurus/' . $picName;
            $img = Image::make($request->file('foto'));
            $img->resize(145, 140);
            $img->save($destinationPath);
            unlink(base_path($pengurus->foto));
            $pengurus->foto = $destinationPath;
        }

        $pengurus->nama = $request->nama;
        $pengurus->jabatan = $request->jabatan;
        if ($pengurus->save()) {
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
        $pengurus = Pengurus::find($id);
        if(!$pengurus){
            $data = [
                "message" => "id not found",
            ];
        } else {
            unlink(base_path($imam->pengurus));
            $pengurus->delete();
            $data = [
                "message" => "Delete Success"
            ];
        }
        return response()->json($data, 200);
    }
}
