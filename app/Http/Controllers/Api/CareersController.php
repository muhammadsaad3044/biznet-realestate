<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Careers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CareersController extends Controller
{
    public function index(Request $request){
        try {
            
            $careers = Careers::with('jobs')->get();  
           
            if($careers){

                return response()->json([
                    'status'=>200,
                    'careers'=>$careers,
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
    
    
    
    
    public function getindex($id){
        try {
            
            $careers = Careers::with('jobs')->where('id', $id)->get();  
           
            if($careers){

                return response()->json([
                    'status'=>200,
                    'careers'=>$careers,
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
                'title' => 'required|string|unique:careers',
                
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $careers = new Careers();
            $careers->user_id = $request->user_id;
            $careers->title = $request->title;
            $careers->description = $request->description;
            $careers->job_id = $request->job_id;           
            $careers->save();
            
            
            if($careers){
            return response()->json([
                'status' => 200,
                'message' => 'Added Successfully!',
            ], 200);  
            }else{
            return response()->json([
                'status' => 400,
            ], 200);  
            }


        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }


    public function update(Request $request, $id){
        try {


            $careers =  Careers::find($id);
            
            if(!$careers){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{
             
            $careers->user_id = $request->user_id;
            $careers->title = $request->title;
            $careers->description = $request->description;
            $careers->job_id = $request->job_id;  
            $careers->save();
    
            if($careers){
                return response()->json([
                    'status' => 200,
                    'message' => 'Updated Successfully!',
                ], 200);
            }
            }
            

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }

    public function destory(Request $request, $id){
        try {
            
            $careers =  Careers::find($id);
       
        
            if($careers){

                $careers->delete();
            
            
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
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }
}
