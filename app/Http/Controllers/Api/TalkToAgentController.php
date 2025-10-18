<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TalkToAgent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TalkToAgentController extends Controller
{
    public function index(){
        try {
            
            $talk_to_agent = TalkToAgent::with('products')->get();   

            if($talk_to_agent){
                return response()->json([
                    'status'=>200,
                    'talk_to_agent'=>$talk_to_agent,
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

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'p_id' => 'required|exists:products,id',
                'phone' => 'required',
                'desc' => 'required',
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $dataArray = [
                'p_id' => $request->p_id,
                'phone'=> $request->phone,
                'description'=> $request->desc,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            TalkToAgent::insert($dataArray);
            
    
            return response()->json([
                'status' => 200,
            ], 200);
    
        } catch (\Throwable $th) {
            
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'p_id' => 'required|exists:products,id',
                'phone' => 'required',
                'desc' => 'required',
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // CHeck If the Record exists of not 

            $dataexist = TalkToAgent::find($id);

            if($dataexist){

                $dataArray = [
                    'p_id' => $request->p_id,
                    'phone'=> $request->phone,
                    'description'=> $request->desc,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
    
                TalkToAgent::update($dataArray);
                
        
                return response()->json([
                    'status' => 200,
                ], 200);

            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Record Not Found',
                ], 200);
            }
    

    
        } catch (\Throwable $th) {
            // Log the exception message
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function destory(Request $request, $id){
        try {
            
            $talk_to_agent = TalkToAgent::find($id);
            
            if($talk_to_agent){
                
                $talk_to_agent->delete();
                    
                return response()->json([
                    'status'=>200,
                    'message'=>'Deleted Successfully!',
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
