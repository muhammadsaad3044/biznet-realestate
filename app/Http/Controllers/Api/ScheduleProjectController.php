<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ScheduleProject;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleProjectController extends Controller
{
    public function index(Request $request){
        try {
            
            $projectschedule = ScheduleProject::get();   

            if($projectschedule){

                return response()->json([
                    'status'=>200,
                    'project_schedule'=> $projectschedule,
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
                'proj_name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $projectschedule = new ScheduleProject();
            $projectschedule->proj_name = $request->proj_name;
            $projectschedule->proj_date = $request->proj_date;
            $projectschedule->proj_desc = $request->proj_desc;
            $projectschedule->estimate_duration = $request->estimate_duration;
            $projectschedule->proj_status = $request->proj_status;
            $projectschedule->assign_team_member = $request->assign_team_member;

            $projectschedule->save();
            
            
            if($projectschedule){

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
                 'proj_name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $projectschedule =  ScheduleProject::find($id);

            if(!$projectschedule){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $projectschedule->proj_name = $request->proj_name;
                $projectschedule->proj_date = $request->proj_date;
                $projectschedule->proj_desc = $request->proj_desc;
                $projectschedule->estimate_duration = $request->estimate_duration;
                $projectschedule->proj_status = $request->proj_status;
                $projectschedule->assign_team_member = $request->assign_team_member;

                $projectschedule->save();

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
            $projectschedule =  ScheduleProject::find($id);
       
        
            if($projectschedule){
                           
            $projectschedule->delete();

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
