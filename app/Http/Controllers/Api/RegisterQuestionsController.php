<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterQuestions;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterQuestionsController extends Controller
{

    public function index(Request $request, $usertype){
        try {
            
            $registerquestions = RegisterQuestions::with('options')->where('user_type', $usertype)->get();   

            if($registerquestions){
                return response()->json([
                    'status'=>200,
                    'questions'=> $registerquestions,
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
                'user_type' => 'required',
                'question' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $registerquestions = new RegisterQuestions();
            $registerquestions->user_type = $request->user_type;
            $registerquestions->question = $request->question;
            $registerquestions->save();
            
            
            if($registerquestions){
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


    public function destory(Request $request, $id){
        
        try {

            $registerquestions =  RegisterQuestions::find($id);
            
            if($registerquestions){
                      
            $registerquestions->delete();

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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);

        }
    }
    
    
    public function update(Request $request, $id)
{
    try {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'user_type' => 'nullable',
            'question' => 'nullable',
        ]);

        // Return validation errors as JSON
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the record by ID
        $registerquestions = RegisterQuestions::find($id);

        if ($registerquestions) {
            // Update the data
            $registerquestions->user_type = $request->user_type;
            $registerquestions->question = $request->question;
            $registerquestions->save();

            return response()->json([
                'status' => 200,
                'message' => 'Updated Successfully!',
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Record Not Found!',
            ], 404);
        }
    } catch (\Throwable $th) {
        return response()->json([
            'error' => $th->getMessage(),
            'status' => 400,
        ], 400);
    }
}

}
