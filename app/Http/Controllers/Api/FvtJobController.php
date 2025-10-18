<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FvtJob;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FvtJobController extends Controller
{
    public function index(Request $request){
        try {
            
            $FvtJob = FvtJob::with('users', 'jobs')->get();  
            
            if($FvtJob){
                
                return response()->json([
                    'status'=>200,
                    'fvt_job'=>$FvtJob,
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


    public function user_index(Request $request, $id){
        try {
            
            $FvtJob = FvtJob::with('users', 'jobs')->where('user_id', $id)->get(); 
            
            if($FvtJob){

                return response()->json([
                    'status'=>200,
                    'fvt_jobs'=>$FvtJob,
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
                'user_id' => 'required|exists:users,id',
                'job_id' => 'required|exists:jobs,id',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $FvtJob = new FvtJob();
            $FvtJob->user_id = $request->user_id;
            $FvtJob->job_id = $request->job_id;
            $FvtJob->save();
            
            
            if($FvtJob){
            return response()->json([
                'status' => 200,
                'message' => 'Added to Fvt Successfully',
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




    public function destory(Request $request, $id){
        try {
            
            $FvtJob =  FvtJob::find($id);
       
        
            if($FvtJob){

            $FvtJob->delete();
            
            return response()->json([
                'status' => 200,
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
