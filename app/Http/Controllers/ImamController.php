<?php

namespace App\Http\Controllers;
use App\Models\Imam;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Helpers\UserHelper;

class ImamController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware("login");
    }

    public function index() {
        UserHelper::can(['admin', 'staff']);
        return response()->json([
            'status'  => 'success',
            'message' => 'Imam list',
            'data'    => Imam::all(),
        ], 200);
    }

    public function list() {
        return response()->json([
            'status'  => 'success',
            'message' => 'Imam visible list',
            'data'    => Imam::where('status', 'visible')->get(),
        ], 200);
    }

    public function show($id) {
        UserHelper::can(['admin', 'staff']);
        return response()->json([
            'status'  => 'success',
            'message' => 'Imam visible list',
            'data'    => Imam::findOrFail($id),
        ], 200);
    }

    public function store(Request $request) {
        UserHelper::can(['admin', 'staff']);
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
        $destinationPath = 'assets/img/imam/' . $picName;
        $img = Image::make($request->file('foto'));
        $img->resize(145, 140);
        $img->save($destinationPath);

        $imam = new Imam;
        $imam->nama = $request->nama;
        $imam->foto = $destinationPath;
        $imam->jabatan = $request->jabatan;
        if ($imam->save()) {
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
        UserHelper::can(['admin', 'staff']);
        $this->validate($request, [
            'nama'    => 'required',
            'jabatan' => 'required'
        ]);
        $imam = Imam::findOrFail($id);

        if ($request->hasFile('foto')) {
            $picName = str_slug($request->nama) . '.' . $request->file('foto')->getClientOriginalExtension();
            $picName = Carbon::now()->timestamp . '-' . $picName;
            $destinationPath = 'assets/img/imam/' . $picName;
            $img = Image::make($request->file('foto'));
            $img->resize(145, 140);
            $img->save($destinationPath);
            unlink(base_path($imam->foto));
            $imam->foto = $destinationPath;
        }

        $imam->nama = $request->nama;
        $imam->jabatan = $request->jabatan;
        if ($imam->save()) {
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
        UserHelper::can(['admin', 'staff']);
        $imam = Imam::find($id);
        if(!$imam){
            $data = [
                "message" => "id not found",
            ];
        } else {
            unlink(base_path($imam->foto));
            $imam->delete();
            $data = [
                "message" => "Delete Success"
            ];
        }
        return response()->json($data, 200);
    }
}
