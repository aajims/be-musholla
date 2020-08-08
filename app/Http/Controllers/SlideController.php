<?php

namespace App\Http\Controllers;
use App\Models\Slider;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Helpers\UserHelper;

class SlideController extends Controller {
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
        $slide = Slider::all();
        $response =[ 
            'status'=>'success',
            'message'=>'Slide Data list',
            'data' => $slide,
        ];
        return response()->json($response, 200);
    }

    public function list() {
        return response()->json([
            'status'  => 'success',
            'message' => 'Slide visible list',
            'data'    => Slider::where('status', 'visible')->get(),
        ], 200);
    }

    public function show($id) {
        UserHelper::can(['admin', 'staff']);
        return response()->json([
            'status'  => 'success',
            'message' => 'Slide visible list',
            'data'    => Slider::findOrFail($id),
        ], 200);
    }

    public function store(Request $request) {
        UserHelper::can(['admin', 'staff']);
        $this->validate($request, [
            'title'    => 'required',
            'content' => 'required'
        ]);
        if ( ! $request->hasFile('foto')) {
            $this->validate($request, [
                'foto' => 'required'
            ]);
        }

        $picName = str_slug($request->title) . '.' . $request->file('foto')->getClientOriginalExtension();
        $picName = Carbon::now()->timestamp . '-' . $picName;
        $destinationPath = 'assets/img/Slide/' . $picName;
        $img = Image::make($request->file('foto'));
        $img->resize(1400, 550);
        $img->save($destinationPath);

        $Slide = new Slide;
        $Slide->title = $request->title;
        $Slide->foto = $destinationPath;
        $Slide->content = $request->content;
        if ($Slide->save()) {
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
            'title'    => 'required',
            'content' => 'required'
        ]);
        $Slide = Slider::findOrFail($id);

        if ($request->hasFile('foto')) {
            $picName = str_slug($request->title) . '.' . $request->file('foto')->getClientOriginalExtension();
            $picName = Carbon::now()->timestamp . '-' . $picName;
            $destinationPath = 'assets/img/Slide/' . $picName;
            $img = Image::make($request->file('foto'));
            $img->resize(140, 550);
            $img->save($destinationPath);
            unlink(base_path($Slide->foto));
            $Slide->foto = $destinationPath;
        }

        $Slide->title = $request->title;
        $Slide->content = $request->content;
        if ($Slide->save()) {
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
        $Slide = Slider::find($id);
        if(!$Slide){
            $data = [
                "message" => "id not found",
            ];
        } else {
            unlink(base_path($Slide->foto));
            $Slide->delete();
            $data = [
                "message" => "Delete Success"
            ];
        }
        return response()->json($data, 200);
    }
}
