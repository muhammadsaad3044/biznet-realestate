<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Careers, ApplyForJob, ApplyForJobMyInfo,ApplyForJobMyExperience,ApplyForJobApplicationQuestions};
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class ApplyForJobController extends Controller
{
    public function index(Request $request){
        try {
            
            $applyforjob = ApplyForJob::with('myinfo' , 'myexperience', 'application_questions')->get();  
            
            if($applyforjob){

                return response()->json([
                    'status'=>200,
                    'all_jobs'=>$applyforjob,
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
                'user_id' => 'required|string|exists:users,id',
                'f_name' => 'required',
                'l_name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $applyforjob = new ApplyForJob();
            $applyforjob->user_id = $request->user_id;
            $applyforjob->f_name = $request->f_name;
            $applyforjob->l_name = $request->l_name;
            $applyforjob->email = $request->email;     
            $applyforjob->phone = $request->phone;        
            $applyforjob->receive_job_related_sms = $request->receive_job_related_sms;  
            $applyforjob->opt_receive_job_related_email = $request->opt_receive_job_related_email;
            $applyforjob->are_you_18_years_old = $request->are_you_18_years_old; 
            $applyforjob->legal_authorized_to_work_united_state = $request->legal_authorized_to_work_united_state;

            $applyforjob->save();
            
            
            if($applyforjob){
            return response()->json([
                'status' => 200,
                'message' => 'Added Successfully!',
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


    public function my_info_store(Request $request){
        
        try {

            $validator = Validator::make($request->all(), [
                'appy_for_job_id' => 'required',
                
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $applyforjob = new ApplyForJobMyInfo();
            $applyforjob->appy_for_job_id = $request->appy_for_job_id;
            $applyforjob->f_name = $request->f_name;
            $applyforjob->l_name = $request->l_name;
            $applyforjob->country = $request->country;
            $applyforjob->preferred_name = $request->preferred_name;          
            $applyforjob->address_line_1 = $request->address_line_1; 
            $applyforjob->address_line_2 = $request->address_line_2; 
            $applyforjob->city = $request->city; 
            $applyforjob->state = $request->state; 
            $applyforjob->zipcode = $request->zipcode; 
            $applyforjob->email = $request->email; 
            $applyforjob->phone_device_type = $request->phone_device_type; 
            $applyforjob->country_phone_code = $request->country_phone_code; 
            $applyforjob->phone = $request->phone; 
            $applyforjob->how_you_hear_about_us = $request->how_you_hear_about_us; 
            $applyforjob->save();
            
            
            if($applyforjob){
            return response()->json([
                'status' => 200,
                'message' => 'Added Successfully!',
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



    public function my_expeirence_store(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'appy_for_job_id' => 'required',
                
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // dd($request->all());
            if (!empty($request->job_title) && $request->job_title[0] != null) {
                // dd("enter");
                $count = count($request->job_title);
                for ($i = 0; $i < $count; $i++) {
                    $dataArray = [
                        'appy_for_job_id' => $request->appy_for_job_id,
                        'job_title' => isset($request->job_title[$i]) ? $request->job_title[$i] : '',
                        'company' => isset($request->company[$i]) ? $request->company[$i] : '',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    ApplyForJobMyExperience::insert($dataArray);


                    return response()->json([
                        'status' => 200,
                        'message' => 'Added Successfully!',
                    ], 200); 
                }
            }


        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }


    public function application_questions_store(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'appy_for_job_id' => 'required',
                
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $applyforjob = new ApplyForJobApplicationQuestions();
            $applyforjob->appy_for_job_id = $request->appy_for_job_id;
            $applyforjob->at_least_18_year_old = $request->at_least_18_year_old;
            $applyforjob->legal_rights_to_work_in_country = $request->legal_rights_to_work_in_country;
            $applyforjob->need_visa_support = $request->need_visa_support;       
            $applyforjob->preferred_pronouns = $request->preferred_pronouns;      
            $applyforjob->save();
            
            
            if($applyforjob){
            return response()->json([
                'status' => 200,
                'message' => 'Added Successfully!',
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
                'user_id' => 'required|string|exists:users,id',
                'f_name' => 'required',
                'l_name' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

    
            $applyforjob =  ApplyForJob::find($id);
            
            if(!$applyforjob){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{
             
                $applyforjob->user_id = $request->user_id;
                $applyforjob->f_name = $request->f_name;
                $applyforjob->l_name = $request->l_name;
                $applyforjob->email = $request->email;     
                $applyforjob->phone = $request->phone;        
                $applyforjob->email = $request->email;  
                $applyforjob->receive_job_related_sms = $request->receive_job_related_sms;  
                $applyforjob->opt_receive_job_related_email = $request->opt_receive_job_related_email;
                $applyforjob->are_you_18_years_old = $request->are_you_18_years_old; 
                $applyforjob->legal_authorized_to_work_united_state = $request->legal_authorized_to_work_united_state; 

                $applyforjob->save();
    
            if($applyforjob){
                return response()->json([
                    'status' => 200,
                    'message' => 'Updated Successfully!',
                ], 200);
            }
            }
            

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }



    public function update_info_store(Request $request, $id){
        try {

            $validator = Validator::make($request->all(), [
                'appy_for_job_id' => 'required',
                
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $applyforjob = ApplyForJobMyInfo::where('appy_for_job_id', $id)->latest('id')->first();

            if(!$applyforjob){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $applyforjob->appy_for_job_id = $request->appy_for_job_id;
                $applyforjob->f_name = $request->f_name;
                $applyforjob->l_name = $request->l_name;
                $applyforjob->country = $request->country;
                $applyforjob->preferred_name = $request->preferred_name;          
                $applyforjob->address_line_1 = $request->address_line_1; 
                $applyforjob->address_line_2 = $request->address_line_2; 
                $applyforjob->city = $request->city; 
                $applyforjob->state = $request->state; 
                $applyforjob->zipcode = $request->zipcode; 
                $applyforjob->email = $request->email; 
                $applyforjob->phone_device_type = $request->phone_device_type; 
                $applyforjob->country_phone_code = $request->country_phone_code; 
                $applyforjob->phone = $request->phone; 
                $applyforjob->how_you_hear_about_us = $request->how_you_hear_about_us; 
                $applyforjob->save();
                
                
                if($applyforjob){
                return response()->json([
                    'status' => 200,
                    'message' => 'Updated Successfully!',
                ], 200);  
                }else{
                return response()->json([
                    'status' => 400,
                ], 200);  
                }

            }

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }



    public function update_expeirence_store(Request $request, $id){
        try {

            $validator = Validator::make($request->all(), [
                'appy_for_job_id' => 'required',
                
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $dataexist = ApplyForJobMyExperience::where('appy_for_job_id', $id)->get();
            
            if($dataexist){
                foreach ($dataexist as $key => $value) {
                    $value->delete();
                }

                if (!empty($request->job_title) && $request->job_title[0] != null) {
                    $count = count($request->job_title);
                    for ($i = 0; $i < $count; $i++) {
                        $dataArray = [
                            'appy_for_job_id' => $request->appy_for_job_id,
                            'job_title' => isset($request->job_title[$i]) ? $request->job_title[$i] : '',
                            'company' => isset($request->company[$i]) ? $request->company[$i] : '',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
    
                        ApplyForJobMyExperience::insert($dataArray);
    
    
                        return response()->json([
                            'status' => 200,
                            'message' => 'Updated Successfully!',
                        ], 200); 
                    }
                }

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


    public function update_application_questions_store(Request $request, $id){
        try {

            $validator = Validator::make($request->all(), [
                'appy_for_job_id' => 'required',
                
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $applyforjob = ApplyForJobApplicationQuestions::where('appy_for_job_id' , $id)->latest('id')->first();

    

        
            
            
            if($applyforjob){

            $applyforjob->user_id = $request->user_id;
            $applyforjob->at_least_18_year_old = $request->at_least_18_year_old;
            $applyforjob->legal_rights_to_work_in_country = $request->legal_rights_to_work_in_country;
            $applyforjob->need_visa_support = $request->need_visa_support;       
            $applyforjob->preferred_pronouns = $request->preferred_pronouns;      
            $applyforjob->save();


            return response()->json([
                'status' => 200,
                'message' => 'Updated Successfully!',
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
            
            $applyforjob =  ApplyForJob::with('myinfo' , 'myexperience', 'application_questions')->find($id);
       
        
            if($applyforjob){

                $applyforjob->myinfo();
                $applyforjob->myexperience();
                $applyforjob->application_questions();
                $applyforjob->delete();
            
            return response()->json([
                'status' => 200,
                'message' => 'Deleted Successfully!',
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
