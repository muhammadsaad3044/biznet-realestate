<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterQuestionsOptions;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterQuestionsOptionsController extends Controller
{
    public function index(Request $request, $questionid){
        try {
            
            $registerquestionsoptions = RegisterQuestionsOptions::where('question_id', $questionid)->get();   

            if($registerquestionsoptions){
                return response()->json([
                    'status'=>200,
                    'question_options'=> $registerquestionsoptions,
                    'imagePath'=>url('/uploads/questions/') . '/',
                    'filePath'=>url('/uploads/files/') . '/',
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
                'question_id' => 'required|exists:register_questions,id',
                'option_value' => 'required',
                // 'doc' => 'mimes:pdf,doc,docx,xls,xlsx',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
        
            $registerquestionsoptions = new RegisterQuestionsOptions();
            $registerquestionsoptions->question_id = $request->question_id;
            $registerquestionsoptions->option_value = $request->option_value;
            
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . date('H-i-s') . '.' . $extension;
                $file->move('uploads/questions/', $filename);
                $registerquestionsoptions->image = $filename;
            }
            // Store the documents
            if ($request->hasfile('doc')) {
                $file = $request->file('doc');
                $extension = $file->getClientOriginalExtension();
                $filename1 = time() . '_' . date('H-i-s') . '.' . $extension;
                $file->move('uploads/files/', $filename1);
                $registerquestionsoptions->doc = $filename1;
            }
            
            $registerquestionsoptions->save();
            
            if($registerquestionsoptions){
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
                'question_id' => 'required|exists:register_questions,id',
                'option_value' => 'required',
                // 'doc' => 'mimes:pdf,doc,docx,xls,xlsx',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $registerquestionsoptions =  RegisterQuestionsOptions::find($id);

            if(!$registerquestionsoptions){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $registerquestionsoptions->question_id = $request->question_id;
                $registerquestionsoptions->option_value = $request->option_value;
                if ($request->hasfile('image')) {
                if(isset($registerquestionsoptions->image) && file_exists('uploads/questions/', $registerquestionsoptions->image)){
                    unlink(public_path('uploads/questions/' . $whatsnewimage->image));
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . date('H-i-s') . '.' . $extension;
                $file->move('uploads/questions/', $filename);
                $registerquestionsoptions->image = $filename;
                }
            
            
            
            if ($request->hasfile('doc')) {
                if(isset($registerquestionsoptions->doc) && file_exists('uploads/files/', $registerquestionsoptions->doc)){
                    unlink(public_path('uploads/files/' . $whatsnewimage->doc));
                }
                $file = $request->file('doc');
                $extension = $file->getClientOriginalExtension();
                $filename1 = time() . '_' . date('H-i-s') . '.' . $extension;
                $file->move('uploads/files/', $filename1);
                $registerquestionsoptions->doc = $filename1;
            }
            
                $registerquestionsoptions->save();
                

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

            $registerquestionsoptions =  RegisterQuestionsOptions::find($id);
    
            if($registerquestionsoptions){
                      
            if(isset($registerquestionsoptions->image) && file_exists('uploads/questions/', $registerquestionsoptions->image)){
                unlink(public_path('uploads/questions/' . $whatsnewimage->image));
            }
            
            if(isset($registerquestionsoptions->doc) && file_exists('uploads/files/', $registerquestionsoptions->doc)){
                unlink(public_path('uploads/files/' . $whatsnewimage->doc));
            }
                
            $registerquestionsoptions->delete();

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
}
