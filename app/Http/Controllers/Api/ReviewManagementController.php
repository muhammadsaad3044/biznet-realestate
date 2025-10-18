<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReviewManagement;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ReviewManagementController extends Controller
{
    public function index(Request $request){
        try {
            
            $reviewmanagement = ReviewManagement::get();   

            if($reviewmanagement){

                return response()->json([
                    'status'=>200,
                    'review_management'=> $reviewmanagement,
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
                'name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $reviewmanagement = new ReviewManagement();
            $reviewmanagement->name = $request->name;
            $reviewmanagement->review = $request->review;
            $reviewmanagement->rating = $request->rating;

            $reviewmanagement->save();
            
            
            if($reviewmanagement){

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

            $reviewmanagement =  ReviewManagement::find($id);

            if(!$reviewmanagement){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $reviewmanagement->name = $request->name;
                $reviewmanagement->review = $request->review;
                $reviewmanagement->rating = $request->rating;

                $reviewmanagement->save();

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
            $reviewmanagement =  ReviewManagement::find($id);
       
        
            if($reviewmanagement){
                           
            $reviewmanagement->delete();

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
