<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailAlerts;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class EmailAlertsController extends Controller
{
    public function index(Request $request){
        try {
            
            $email_alerts = EmailAlerts::get();  
            
            if($email_alerts->isNotEmpty()){
                

                
                return response()->json([
                    'status'=>200,
                    'emails_alerts'=>$email_alerts,
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
                'email' => 'required|email',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $email_alerts = new EmailAlerts();
            $email_alerts->email = $request->email;
            $email_alerts->get_emails = $request->get_emails;
            $email_alerts->save();
            
            
            if($email_alerts){
            return response()->json([
                'status' => 200,
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
}
