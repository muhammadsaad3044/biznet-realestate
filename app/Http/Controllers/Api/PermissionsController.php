<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{permissions};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PermissionsController extends Controller
{
    public function index(Request $request){
        try {
            
            $permissions = permissions::with('roles')->get();   

            if($permissions){
                return response()->json([
                    'status'=>200,
                    'permissions'=>$permissions,
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
                'role_id' => 'required|exists:roles,id',
                'permission_name' => 'required|string|unique:permissions,permission_name',
                'value'=>'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $permissions = new permissions();
            $permissions->role_id = $request->role_id;
            $permissions->permission_name = $request->permission_name;
            $permissions->value = $request->value;
            $permissions->save();
            
            
            if($permissions){

            return response()->json([
                'status' => 200,
                'message'=>'Permission Added Successfully!',
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
                'role_id' => 'required|exists:roles,id',
                'permission_name' => 'required|string|unique:permissions,permission_name',
                'value'=>'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $permissions =  permissions::find($id);

            if(!$permissions){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $permissions->role_id = $request->role_id;
                $permissions->permission_name = $request->permission_name;
                $permissions->value = $request->value;
                $permissions->save();

                return response()->json([
                    'status' => 200,
                    'message'=>'Permission Upodate Successfully!',
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
            $permissions =  permissions::find($id);
       
        
            if($permissions){
                           
            $permissions->delete();

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
