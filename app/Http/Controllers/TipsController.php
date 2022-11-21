<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tips =Tip::paginate(5);
        return response()->json([
            'data'=> $tips,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tips = Tip::create([
            'title' => $request->title,
            'thumbnail' => $request->thumbnail,
            'url' => $request->url,
        ]);
        return response()->json([
            'data' => $tips,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return response()->json([
        //     'data'=> Tip::where('id',$id)->get(),
        //     'token' => null,
        // ]);
        $program = Tip::find($id);
        if (is_null($program)) {
            return response()->json(['message'=>'Data not found'], 404); 
        }
        return response()->json(['message'=>'OK','data'=>$program]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $tips->title = $request->title;
        // $tips->thumbnail = $request->thumbnail;
        // $tips->url = $request->url;
        // $tips->update();
        // return response()->json([
        //     'data' => $tips,
        // ]);
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'thumbnail' => 'required',
            'url' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $tips->title = $request->title;
        $tips->thumbnail = $request->thumbnail;
        $tips->url = $request->url;
        $tips->save();
        
        return response()->json(['message'=>'Program updated successfully.']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Tip::delete('id',$id);
        $tips = Tip::find($id);
        if ($tips) {
            $tips->delete();
            return response()->json([
            'message' => 'terhapus ...',
        ]);
        } else {
            return response()->json([
            'message' => 'cek data ...',
        ]);
        }
        
        
    }
}
