<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpeicalOffer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SpecialOfferController extends Controller
{
    public function index(Request $request){
        try {
            
            $special_offer = SpeicalOffer::get();   

            if($special_offer){
                return response()->json([
                    'status'=>200,
                    'special_offers'=>$special_offer,
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
                'pd_id' => 'required|exists:products,id',
                'discount' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $special_offer = new SpeicalOffer();
            $special_offer->user_id = $request->user_id;
            $special_offer->pd_id = $request->pd_id;
            $special_offer->discount = $request->discount;
            $special_offer->save();
            
            
            if($special_offer){
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
                'user_id' => 'required|exists:users,id',
                'pd_id' => 'required|exists:products,id',
                'discount' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $special_offer =  SpeicalOffer::find($id);

            if(!$special_offer){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $special_offer->user_id = $request->user_id;
                $special_offer->pd_id = $request->pd_id;
                $special_offer->discount = $request->discount;
                $special_offer->save();

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
            $special_offer =  SpeicalOffer::find($id);
       
        
            if($special_offer){
          
            $special_offer->delete();

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
