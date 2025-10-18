<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AnwserRegisterQuestions;
use App\Models\roles;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
// use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Mail\PasswordReset;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function getusers(){
        try {
            $users = User::with('roles.permissions')->get();

            if(isset($users[0])){
                return response()->json([
                    'status'=>200,
                    'allusers'=>$users,
                    'imagePath'=>url('/uploads/users/'),
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
    
    
    
    
    
    
    public function getallagents(){
        try {
            $users = User::with('roles.permissions')->where('user_role', '10')->get();

            if(isset($users[0])){
                return response()->json([
                    'status'=>200,
                    'allusers'=>$users,
                    'imagePath'=>url('/uploads/users/'),
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
    
    
    public function getuserprofile($id){
        try {
            $users = User::with('roles.permissions')->where('id', $id)->first();

            if(isset($users)){
                return response()->json([
                    'status'=>200,
                    'allusers'=>$users,
                    'imagePath'=>url('/uploads/users/'),
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
    
    
    public function getuseragent($title){
        try {
            
            // $users = User::with('roles.permissions')
            //     ->whereHas('roles', function ($query) use ($title) {
            //         $query->where('roles.title', 'like', '%'.$title.'%');
            //     })
            //     ->get();
            
            
            $users = User::with('roles.permissions')
                    ->where('name', 'like', '%'.$title.'%')
                    ->where('user_role', '10')
                    ->get();


            if(isset($users[0])){
                return response()->json([
                    'status'=>200,
                    'users'=>$users,
                    'imagePath'=>url('/uploads/users/'),
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
    
    public function register(Request $request)
    {
   
                
         // Create a validator instance
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'user_role' => 'required|string',
            'password' => 'required|string|min:8',
        ]);
    
        // Return validation errors as JSON
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
    
        
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'is_admin' => 0,
                'user_role' => $request->user_role,
                'agent_id' => $request->agent_id,
                'password' => Hash::make($request->password),
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;
            
            
            

            if (isset($request->answers) && is_array($request->answers)) {
                
                    $dataArray = [];
                
                    foreach ($request->answers as $answer) {
                        $dataArray[] = [
                            'user_id' => $user->id,                         // Assuming $user->id is available
                            'question_id' => $answer['question_id'] ?? '',  // Get the question_id or default to an empty string
                            'anwser' => $answer['answer_id'] ?? '',      // Get the answer_id or default to an empty string
                            'is_custom' => $answer['isCustom'] ?? false,    // Get the isCustom flag or default to false
                            'created_at' => now(),                          // Current timestamp for created_at
                            'updated_at' => now(),                          // Current timestamp for updated_at
                        ];
                    }
                    
                // Batch insert
                $inserted = AnwserRegisterQuestions::insert($dataArray);
    
            }

            
    
            return response()->json([
                'access_token' => $token,
                'user_role' => isset(roles::find($user->user_role)->role_name) ? roles::find($user->user_role)->role_name : '',
                'token_type' => 'Bearer',
                'user_id' => $user->id,
                'message' => 'User Created SuccessFully!'
            ]);
    }

    public function login(Request $request)
    {
        
        if(empty($request->email) && empty($request->password)){
            return response()->json([
                'status' => 'error',
                'errors' => 'Username & Password are required',
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
       
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['The provided credentials are incorrect.'
            ], 422);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user_id' => $user->id,
            'role_id' => (int)$user->user_role,
            'role_name' => User::with('roles')->where('id' , $user->id)->first(),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    
    
    public function checkuserlogin(Request $request)
    {
        
        if(empty($request->email)){
            return response()->json([
                'status' => 'error',
                'errors' => 'Email is required',
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        
        if($user){
            
        return response()->json([
            'user_id' => $user->id,
            'role_id' => (int)$user->user_role,
            'role_name' => User::with('roles')->where('id' , $user->id)->first(),
        ]);
        
        }else{
            
            return response()->json([
            'message' => 'No Email Found!',
     
        ]);
        
        }


    }
    
    
    
    public function sendResetLinkEmail(Request $request){
        
        try {
            
        $request->validate(['email' => 'required|email']);

        // Generate the token
        $token = Str::random(60);

        // Generate the reset URL
        $url = url('https://api.biznetusa.com/api/reset-password?token=' . $token . '&email=' . urlencode($request->email));

        // Here you can store the token in the database associated with the user's email  (Use If Needed)
        // First Check if toekn already exists or not
        $tokenexists = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        
        if(isset($tokenexists)){
             DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        }
        DB::table('password_reset_tokens')->insert(['email' => $request->email, 'token' => $token, 'created_at' => now()]);

        return response()->json(['reset_link' => $url], 200);
        

                    
        
        } catch (\Throwable $th) {
            
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }
    
    
    
    public function reset(Request $request){
        
        try {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
                
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
            
    
        
        // Retrieve the reset record
        // $resetRecord = DB::table('password_reset_tokens')
        //                 ->where('email', $request->email)
        //                 ->where('token', $request->token)
        //                 ->latest('id')
        //                 ->first();
        
        // if (!$resetRecord) {
            
        //     return response()->json(['message' => 'Invalid token or email'], 400);
        // }

        
        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update the user's password
        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        // Delete the reset record
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
    
        Mail::to($user->email)->send(new PasswordReset($user));
        return response()->json(['message' => 'Password reset successful'], 200);
                    
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    
    
    public function changepassword(Request $request){
    
        try {
             $validator = Validator::make($request->all(), [
                    'email' => 'required|string',
                    'current_password' => 'required|string',
                    'new_password' => 'required|string|min:8',
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
          
             $user = User::where('email' , $request->email)->first();
             
             if($user){
                 
                    if (!Hash::check($request->current_password, $user->password)) {
              
                    return response()->json([
                        'message' => 'The provided password does not match our current records.',
                        'status' => 404,
                    ], 404);
                        
                    }
        
                $user->password = Hash::make($request->new_password);
                $user->save();
        
                return response()->json(['message' => 'Password changed successfully.']); 
            
             }else{
                 
                return response()->json([
                    'message' => 'Record Not Found!',
                    'status' => 404,
                ], 404);
                
             }
         
         
         
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }



    }
    
    public function profileupdate(Request $request, $id){
        
        try {
             $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|string',
                    'user_role' =>  'required|string',
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
          
             $user = User::find($id);
             
             if($user){
    
                $user->name = $request->name;
                $user->email = $request->email;
                $user->user_role = $request->user_role;
                $user->phone_number_type = $request->phone_number_type;
                $user->phone_number = $request->phone_number;
                $user->agent_id = $request->agent_id;
                $user->connect_with_facebook = $request->connect_with_facebook;
                $user->connect_with_google = $request->connect_with_google;

                if ($request->hasfile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/users/', $filename);
                    $banner->user = $filename;
                }

                $user->save();
        
                return response()->json(['message' => 'Profile Updated Successfully.']); 
            
             }else{
                 
                return response()->json([
                    'message' => 'Record Not Found!',
                    'status' => 404,
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
