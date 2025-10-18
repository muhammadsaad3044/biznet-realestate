<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ProjectInquries;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProjectInquiresController extends Controller
{
    public function index(Request $request){
        try {
            
            $projectinquires = ProjectInquries::get();   

            if($projectinquires){

                return response()->json([
                    'status'=>200,
                    'project_inquires'=> $projectinquires,
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
                'client_name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $projectinquires = new ProjectInquries();
            $projectinquires->client_name = $request->client_name;
            $projectinquires->description = $request->description;
            $projectinquires->client_email = $request->client_email;
            $projectinquires->priority_level = $request->priority_level;
            $projectinquires->save();
            
            
            if($projectinquires){

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
                 'client_name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $projectinquires =  ProjectInquries::find($id);

            if(!$projectinquires){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $projectinquires->client_name = $request->client_name;
                $projectinquires->description = $request->description;
                $projectinquires->client_email = $request->client_email;
                $projectinquires->priority_level = $request->priority_level;
                $projectinquires->save();

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
            $projectinquires =  ProjectInquries::find($id);
       
        
            if($projectinquires){
                           
            $projectinquires->delete();

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
