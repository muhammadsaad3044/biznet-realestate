<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{product,FvtProducts};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class FvtProductCOntroller extends Controller
{
    public function index(Request $request, $id){

        try {
            
            $fvt = FvtProducts::where('user_id', $id)->pluck('p_id');

            if($fvt->isNotEmpty()){

                $products = product::with('images')->whereIn('id', $fvt)->get();

                return response()->json([
                    'status'=>200,
                    'products'=>$products,
                    'imagePath'=>"https://biznetusa.com/uploads/products/",
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
                'p_id' => 'required|exists:products,id',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $fvt = new FvtProducts();
            $fvt->user_id = $request->user_id;
            $fvt->p_id = $request->p_id;
            $fvt->save();
            
            
            if($fvt){
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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }

    public function destory(Request $request, $id){
        try {

            $fvt =  FvtProducts::find($id);

            if($fvt){

            $fvt->delete();

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
