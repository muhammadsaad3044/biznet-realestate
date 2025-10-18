<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopHeadlines;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class TopHeadlinesController extends Controller
{
    public function index(Request $request){
        try {
            
            $topheadlines = TopHeadlines::get();   

            if($topheadlines){
                return response()->json([
                    'status'=>200,
                    'headlines'=>$topheadlines,
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
    
    
            $topheadlines = new TopHeadlines();
            $topheadlines->title = $request->title;
            $topheadlines->status = $request->status;
            $topheadlines->save();
            
            
            if($topheadlines){
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

            $topheadlines =  TopHeadlines::find($id);

            if(!$topheadlines){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $topheadlines->title = $request->title;
                $topheadlines->status = $request->status;
                $topheadlines->save();

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
            $topheadlines =  TopHeadlines::find($id);
       
        
            if($topheadlines){
                         
            $topheadlines->delete();

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
