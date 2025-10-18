<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Jobs,Joblocation};
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class JobsController extends Controller
{
    public function index(Request $request){
        try {
      
            $jobs = Jobs::with('job_location', 'careers')->get();   

            if($jobs){
                return response()->json([
                    'status'=>200,
                    'jobs'=>$jobs,
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
    
    
    public function getjobdata($search){
        try {
            
            $jobs = Jobs::with('job_location', 'careers')
                ->when($search, function($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                            ->orWhere('job_type', 'like', '%' . $search . '%')
                            ->orWhere('post_by', 'like', '%' . $search . '%')
                            ->orWhere('status', 'like', '%' . $search . '%')
                            ->orWhere('description', 'like', '%' . $search . '%');
                })
                ->whereHas('job_location', function($query) use ($search) {
                    $query->where('location_id', $search);
                })
                ->whereHas('careers', function($query) use ($search) {
                     $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                })
                ->get();


            if($jobs){
                return response()->json([
                    'status'=>200,
                    'data'=>$jobs,
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
    
    
    
    
    
    public function get_approve_job(Request $request){
        try {
      
            $jobs = Jobs::with('job_location', 'careers')->where('status', 1)->get();   

            if($jobs){
                return response()->json([
                    'status'=>200,
                    'jobs'=>$jobs,
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
    
    
    public function approve_job(Request $request){
        try {
      
            $validator = Validator::make($request->all(), [
                'job_id' => 'required|exists:jobs,id',

            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $jobs = Jobs::where('id', $request->job_id)->first();   
            

            if($jobs){
                
                $jobs->status = $request->status;
                $jobs->save();
                return response()->json([
                    'status'=>200,
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
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|unique:jobs,title',
                'desc' => 'required',
                'post_by' => 'required',
                'status' => 'required',
                'end_date' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $jobs = new Jobs();
            $jobs->career_id = $request->career_id;
            $jobs->title = $request->title;
            $jobs->description = $request->desc;
            $jobs->post_by = $request->post_by;
            $jobs->status = $request->status;
            $jobs->job_type = $request->job_type;
            $jobs->end_date = $request->end_date;
            $jobs->save();
            
            
            if($jobs){

            if (!empty($request->job_location) && $request->job_location[0] != null) {
                $count = count($request->job_location);
                for ($i = 0; $i < $count; $i++) {
                    $dataArray = [
                        'job_id' => $jobs->id,
                        'location_id' => isset($request->job_location[$i]) ? $request->job_location[$i] : '',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    Joblocation::insert($dataArray);
                }
            }


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
                'title' => ['required','string', Rule::unique('jobs')->ignore($id),
                'desc' => 'required',
                'end_date' => 'required',
                'post_by' => 'required',
                'status' => 'required',
                ],
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $jobs =  Jobs::with('job_location')->find($id);

            if(!$jobs){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $jobs->job_location()->delete();

                $jobs->title = $request->title;
                $jobs->career_id = $request->career_id;
                $jobs->job_type = $request->job_type;
                $jobs->description = $request->desc;
                $jobs->post_by = $request->post_by;
                $jobs->status = $request->status;
                $jobs->end_date = $request->end_date;


                $jobs->save();

                if($jobs){
                    
                    if (!empty($request->job_location) && $request->job_location[0] != null) {
                        $count = count($request->job_location);
                        for ($i = 0; $i < $count; $i++) {
                            $dataArray = [
                                'job_id' => $jobs->id,
                                'location_id' => isset($request->job_location[$i]) ? $request->job_location[$i] : '',
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
        
                            Joblocation::insert($dataArray);
                        }
                    }
                }

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

            $jobs =  Jobs::with('job_location')->find($id);
    
            if($jobs){
            
            $jobs->job_location()->delete();
            $jobs->delete();

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
