<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainFaqs;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MainFaqsController extends Controller
{
    public function index(Request $request){
        try {
            
            $mainfaqs = MainFaqs::get();   

            if($mainfaqs){

                return response()->json([
                    'status'=>200,
                    'mainfaqs'=> $mainfaqs,
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
    
    
            $mainfaqs = new MainFaqs();
            $mainfaqs->title = $request->title;
            $mainfaqs->desc = $request->desc;
            $mainfaqs->save();
            
            
            if($mainfaqs){

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
                'name' => 'required|string',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $mainfaqs =  MainFaqs::find($id);

            if(!$mainfaqs){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $mainfaqs->title = $request->title;
                $mainfaqs->desc = $request->desc;
                $mainfaqs->save();

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
            $mainfaqs =  MainFaqs::find($id);
       
        
            if($mainfaqs){
                           
            $mainfaqs->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Deleted Successfully',
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
