<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TiffenyAQuestion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TiffenyAQuestionController extends Controller
{
    public function index(){
        try {
            
            $tiffenyquestion = TiffenyAQuestion::get();   

            if($tiffenyquestion){
                return response()->json([
                    'status'=>200,
                    'tiffeny_a_question'=>$tiffenyquestion,
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
                'phone' => 'required',
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $dataArray = [
                'phone' => $request->phone,
                'considering'=> $request->considering,
                'what_we_do'=> $request->what_we_do,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            TiffenyAQuestion::insert($dataArray);
            
    
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


    public function destory(Request $request, $id){
        try {
            
            $tiffenyquestion = TiffenyAQuestion::find($id);
            
            if($tiffenyquestion){
                
                $tiffenyquestion->delete();
                    
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
