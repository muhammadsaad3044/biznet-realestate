<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewList;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NewListController extends Controller
{
    public function index(Request $request){
        try {
            
            $newList = NewList::get();   

            if($newList){

                return response()->json([
                    'status'=>200,
                    'new_list'=> $newList,
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
            
            $newList = NewList::where('user_id', $id)->get();   

            if($newList){

                return response()->json([
                    'status'=>200,
                    'new_list'=> $newList,
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
                'name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $newList = new NewList();
            $newList->user_id = $request->user_id;
            $newList->name = $request->name;
            $newList->primarily_list = $request->primarily_list;
            $newList->save();
            
            
            if($newList){

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
                'user_id' => 'required|exists:users,id',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $newList =  NewList::find($id);

            if(!$newList){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
               
                $newList->name = $request->name;
                $newList->user_id = $request->user_id;
                $newList->primarily_list = $request->primarily_list;
                $newList->save();

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
            $newList =  NewList::find($id);
       
        
            if($newList){
                           
            $newList->delete();

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
