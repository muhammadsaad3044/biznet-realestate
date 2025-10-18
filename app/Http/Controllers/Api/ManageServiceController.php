<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ManageServicelisting;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ManageServiceController extends Controller
{
    public function index(Request $request){
        try {
            
            $manageservice = ManageServicelisting::get();   

            if($manageservice){

                return response()->json([
                    'status'=>200,
                    'manage_services'=> $manageservice,
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
                'service_name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $manageservice = new ManageServicelisting();
            $manageservice->service_name = $request->service_name;
            $manageservice->description = $request->description;
            $manageservice->category = $request->category;
            $manageservice->price = $request->price;
            $manageservice->status = $request->status;
            $manageservice->save();
            
            
            if($manageservice){

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
               'service_name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $manageservice =  ManageServicelisting::find($id);

            if(!$manageservice){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $manageservice->service_name = $request->service_name;
                $manageservice->description = $request->description;
                $manageservice->category = $request->category;
                $manageservice->price = $request->price;
                $manageservice->status = $request->status;
                $manageservice->save();

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
            $manageservice =  ManageServicelisting::find($id);
       
        
            if($manageservice){
                           
            $manageservice->delete();

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
