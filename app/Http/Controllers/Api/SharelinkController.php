<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{product,FvtProducts,sharelisting};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SharelinkController extends Controller
{
    public function index(Request $request){
        try {
            
            $sharelist = sharelisting::all();   

            if($sharelist){
                return response()->json([
                    'status'=>200,
                    'sharelisting'=>$sharelist,
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
                'email' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $sharelist = new sharelisting();
            $sharelist->email = $request->email;
            $sharelist->desc = $request->desc;
            $sharelist->product_slug = $request->product_slug;
         
            $sharelist->save();
            
            if($sharelist){
            return response()->json([
                'status' => 200,
            ], 200);  
            }else{
            return response()->json([
                'status' => 400,
            ], 200);  
            }


        } catch (\Throwable $th) {

            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }

    public function update(Request $request, $id){
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $sharelist =  sharelisting::find($id);

            if(!$sharelist){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $sharelist->email = $request->email;
                $sharelist->desc = $request->desc;
                $sharelist->product_slug = $request->product_slug;
                $sharelist->save();

                return response()->json([
                    'status' => 200,
                ], 200);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }

    public function destory(Request $request, $id){
        
        try {
            $sharelist =  sharelisting::find($id);
       
        
            if($sharelist){
                                
            $sharelist->delete();
            
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
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }
}
