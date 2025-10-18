<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{UserProfiling};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserProfilingController extends Controller
{
    public function index(Request $request){
        try {
            
            $userprofiling = UserProfiling::with('users')->get();   

            if($userprofiling){
                return response()->json([
                    'status'=>200,
                    'user_profiling'=>$userprofiling,
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
    
    
    
    
    
    
    public function getUserindex($id){
        try {
            
            $userprofiling = UserProfiling::with('users')->where('user_id', $id)->get();   

            if($userprofiling){
                return response()->json([
                    'status'=>200,
                    'user_profiling'=>$userprofiling,
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
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'=> 'error',
                    'errors' => $validator->errors(),
                ], 422);
            }
    
    
            $userprofiling = new UserProfiling();
            $userprofiling->user_id = $request->user_id;
            $userprofiling->current_credit_score = $request->current_credit_score;
            $userprofiling->empoyment_status = $request->empoyment_status;
            $userprofiling->buy_home_or_investing_property = $request->buy_home_or_investing_property;
            $userprofiling->purchase_home_or_investing_property = $request->purchase_home_or_investing_property;
            $userprofiling->opening_working_with_private_lender = $request->opening_working_with_private_lender;
            $userprofiling->fimilar_with_buy_or_investing_property = $request->fimilar_with_buy_or_investing_property;
            $userprofiling->working_as_realtor = $request->working_as_realtor;
            $userprofiling->bought_house_before = $request->bought_house_before;
            $userprofiling->save();
            
            
            if($userprofiling){
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
                'user_id' => 'required',
                ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $userprofiling =  UserProfiling::find($id);

            if(!$userprofiling){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $userprofiling->user_id = $request->user_id;
                $userprofiling->current_credit_score = $request->current_credit_score;
                $userprofiling->empoyment_status = $request->empoyment_status;
                $userprofiling->buy_home_or_investing_property = $request->buy_home_or_investing_property;
                $userprofiling->purchase_home_or_investing_property = $request->purchase_home_or_investing_property;
                $userprofiling->opening_working_with_private_lender = $request->opening_working_with_private_lender;
                $userprofiling->fimilar_with_buy_or_investing_property = $request->fimilar_with_buy_or_investing_property;
                $userprofiling->working_as_realtor = $request->working_as_realtor;
                $userprofiling->bought_house_before = $request->bought_house_before;
                $userprofiling->save();

                return response()->json([
                    'status' => 200,
                    'message'=>'Upodate Successfully!',
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

            $userprofiling =  UserProfiling::find($id);
    
            if($userprofiling){
                      
            $userprofiling->delete();

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
