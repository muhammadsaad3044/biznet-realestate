<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{HomeByCity};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HomeByCityController extends Controller
{
    public function index(Request $request){
        try {
            
            $home_by_city = HomeByCity::get();   

            if($home_by_city){
                return response()->json([
                    'status'=>200,
                    'home_by_city'=>$home_by_city,
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
                'title' => 'required|string|unique:home_by_cities,title',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $home_by_city = new HomeByCity();
            $home_by_city->title = $request->title;
            $home_by_city->save();
            
            
            if($home_by_city){
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
                'title' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $home_by_city =  HomeByCity::find($id);

            if(!$home_by_city){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $home_by_city->title = $request->title;
                $home_by_city->save();

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

            $home_by_city =  HomeByCity::find($id);
    
            if($home_by_city){
                      
            $home_by_city->delete();

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
