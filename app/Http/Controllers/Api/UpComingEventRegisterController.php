<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UpcomingEmailRegister;
use App\Models\UpcomingEmails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpComingEventRegisterController extends Controller
{
    public function index(Request $request){
        try {
            
            $upcomingevents = UpcomingEmailRegister::get();   

            if($upcomingevents){
                return response()->json([
                    'status'=>200,
                    'upcomingeventsregister'=>$upcomingevents,
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
                'upcoming_email_id' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $upcomingevents = new UpcomingEmailRegister();
            $upcomingevents->upcoming_email_id = $request->upcoming_email_id;
            $upcomingevents->name = $request->name;
            $upcomingevents->phone = $request->phone;
            $upcomingevents->email = $request->email;
            $upcomingevents->address = $request->address;
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
                'upcoming_email_id' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $upcomingevents =  UpcomingEmailRegister::find($id);

            if(!$upcomingevents){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
            $upcomingevents->upcoming_email_id = $request->upcoming_email_id;
            $upcomingevents->name = $request->name;
            $upcomingevents->phone = $request->phone;
            $upcomingevents->email = $request->email;
            $upcomingevents->address = $request->address;
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
            $upcomingevents =  UpcomingEmailRegister::find($id);
       
        
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
