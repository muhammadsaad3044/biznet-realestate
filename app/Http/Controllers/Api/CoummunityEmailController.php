<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use App\Jobs\SendCommunityEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CoummunityEmailController extends Controller
{
    public function sendemail(Request $request){

        try {
            
            $users = User::all();   

            if($users){

                if ($users->isEmpty()) {
                    return response()->json(['message' => 'No community users found.'], 404);
                }
        
                foreach ($users as $user) {
                
                    SendCommunityEmail::dispatch($user);
                    
                }
        
                return response()->json(['message' => 'Emails are being sent in the background.'], 200);
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
