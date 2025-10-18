<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UpcomingEmailRegister;
use App\Models\UpcomingEmails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpComingEventsController extends Controller
{
    public function index(Request $request){
        try {
            
            $upcomingevents = UpcomingEmails::get();   

            if($upcomingevents){
                return response()->json([
                    'status'=>200,
                    'upcomingevents'=>$upcomingevents,
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
                'title' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $upcomingevents = new UpcomingEmails();
            
            $upcomingevents->title = $request->title;
            $upcomingevents->desc = $request->desc;
            $upcomingevents->address = $request->address;
            $upcomingevents->start_time = $request->start_time;
            $upcomingevents->end_time = $request->end_time;
            $upcomingevents->date = $request->date;
            

            $upcomingevents->save();
            
            
            if($upcomingevents){
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
                'title' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $upcomingevents =  UpcomingEmails::find($id);

            if(!$upcomingevents){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

            $upcomingevents->title = $request->title;
            $upcomingevents->desc = $request->desc;
            $upcomingevents->address = $request->address;
            $upcomingevents->start_time = $request->start_time;
            $upcomingevents->end_time = $request->end_time;
            $upcomingevents->date = $request->date;
                $upcomingevents->save();

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
            $upcomingevents =  UpcomingEmails::find($id);
       
        
            if($upcomingevents){
                         
            $upcomingevents->delete();

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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
}
