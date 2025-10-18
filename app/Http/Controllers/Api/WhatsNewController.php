<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatsNew;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class WhatsNewController extends Controller
{
    public function index(Request $request){
        try {
            
            $whatsnew = WhatsNew::with('images')->get();   

            if($whatsnew){
                return response()->json([
                    'status'=>200,
                    'whatsnew'=>$whatsnew,
                    'imagePath' => url('uploads/whatsnew/'). '/',
                ], 200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function store(Request $request){
        try {
            
            $validator = Validator::make($request->all(), [
                'title' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $whatsnew = new WhatsNew();
            $whatsnew->title = $request->title;
            $whatsnew->desc = $request->desc;
            $whatsnew->date = $request->date;
            $whatsnew->save();
            
            
            if($whatsnew){


            $images = $request->image;


            foreach ($images as $index => $file) {
                    
                $image = "";
                
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $extension = $file->getClientOriginalExtension(); 
                    $filename = time() . $index . '.' . $extension;
                    $file->move('uploads/whatsnew/', $filename);
                    $image = $filename; // Save the filename
                }
    
                // Store the image and corresponding video (or null if no video)
                $dataArray = [
                    'whats_new_id' => $whatsnew->id,
                    'image' => $image,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                
                \App\Models\WhatsNewImages::insert($dataArray);

            }

            return response()->json([
                'status' => 200,
                'message'=>'Added Successfully!',
            ], 200);  
            }else{
            return response()->json([
                'status' => 400,
                'message'=>'Something Went Wrong!',
            ], 200);  
            }


        } catch (\Throwable $th) {

            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function update(Request $request, $id){
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $whatsnew =  WhatsNew::find($id);

            if(!$whatsnew){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $whatsnew->title = $request->title;
                $whatsnew->desc = $request->desc;
                $whatsnew->date = $request->date;
                $whatsnew->save();

                return response()->json([
                    'status' => 200,
                    'message'=>'Update Successfully!',
                ], 200);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function destory(Request $request, $id){
        
        try {
            $whatsnew =  WhatsNew::with('images')->find($id);
       
            if($whatsnew){
                         
            $whatsnew->images();
            $whatsnew->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Deleted Successfully!',
            ], 200);
            
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
}
