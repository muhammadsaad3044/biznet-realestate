<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StartAnOffer;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StartAnOfferController extends Controller
{
    public function index(Request $request){
        try {
            
            $startOffer = StartAnOffer::get();   

            if($startOffer){

                return response()->json([
                    'status'=>200,
                    'start_an_offer'=> $startOffer,
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
    
    
    public function product_index($id){
        try {
            
            $startOffer = StartAnOffer::where('p_id', $id)->get();   

            if($startOffer){

                return response()->json([
                    'status'=>200,
                    'start_an_offer'=> $startOffer,
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
    
    
    
    public function user_index($id){
        try {
            
            $startOffer = StartAnOffer::where('user_id', $id)->get();   

            if($startOffer){

                return response()->json([
                    'status'=>200,
                    'start_an_offer'=> $startOffer,
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
                'p_id' => 'required|exists:products,id',
                'user_id' =>'required|exists:users,id',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $startOffer = new StartAnOffer();
            $startOffer->p_id = $request->p_id;
            $startOffer->user_id = $request->user_id;
            $startOffer->phone = $request->phone;
            $startOffer->how_much_you_offer = $request->how_much_you_offer;
            $startOffer->plan_on_buying = $request->plan_on_buying;
            $startOffer->tour_this_home_in_person = $request->tour_this_home_in_person;
            $startOffer->comments = $request->comments;
            $startOffer->save();
            
            
            if($startOffer){

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
                'p_id' => 'required|exists:products,id',
                'user_id' =>'required|exists:users,id',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $startOffer =  StartAnOffer::find($id);

            if(!$startOffer){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $startOffer->p_id = $request->p_id;
                $startOffer->user_id = $request->user_id;
                $startOffer->phone = $request->phone;
                $startOffer->how_much_you_offer = $request->how_much_you_offer;
                $startOffer->plan_on_buying = $request->plan_on_buying;
                $startOffer->tour_this_home_in_person = $request->tour_this_home_in_person;
                $startOffer->comments = $request->comments;
                $startOffer->save();

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
            $startOffer =  StartAnOffer::find($id);
       
        
            if($startOffer){
                           
            $startOffer->delete();

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
