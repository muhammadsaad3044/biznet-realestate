<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Community;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CommunityController extends Controller
{
    public function index(Request $request){
        try {
            
            $community = Community::all();   

            if($community){
                return response()->json([
                    'status'=>200,
                    'community'=>$community,
                    'filePath'=>url('/uploads/resume/'),
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

    public function store(Request $request){
        try {
        
            $validator = Validator::make($request->all(), [
                'f_name' => 'required',
                'l_name' => 'required',
                'email' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $community = new Community();
            $community->f_name = $request->f_name;
            $community->l_name = $request->l_name;
            $community->email = $request->email;
            $community->phone = $request->phone;
            $community->area_of_interst = $request->area_of_interst;
            $community->location = $request->location;
            $community->privacy_policy = $request->privacy_policy;
         
            if ($request->hasfile('resume')) {
                $file = $request->file('resume');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/resume/', $filename);
                $community->upload_documents = $filename;
            }
            
            $community->save();
            
            
            if($community){
            return response()->json([
                'status' => 200,
                'message'=> 'Added Succfully!',
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



    public function destory(Request $request, $id){
        
        try {
            $community =  Community::find($id);
       
        
            if($community){
                                
            $community->delete();
            
            
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
