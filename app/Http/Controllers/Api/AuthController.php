<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AnwserRegisterQuestions;
use App\Models\roles;
use App\Models\PasswordOtp;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Get all users with roles & permissions
    public function getusers()
    {
        try {
            $users = User::with('roles.permissions')->get();

            if (isset($users[0])) {
                return response()->json([
                    'status' => 200,
                    'allusers' => $users,
                    'imagePath' => url('/uploads/users/'),
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Record Not Found!',
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }

    // Get all agents (users with user_role = 10)
    public function getallagents()
    {
        try {
            $users = User::with('roles.permissions')->where('user_role', '10')->get();

            if (isset($users[0])) {
                return response()->json([
                    'status' => 200,
                    'allusers' => $users,
                    'imagePath' => url('/uploads/users/'),
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Record Not Found!',
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }

    // Get single user profile by id
    public function getuserprofile($id)
    {
        try {
            $users = User::with('roles.permissions')->where('id', $id)->first();

            if ($users) {
                return response()->json([
                    'status' => 200,
                    'allusers' => $users,
                    'imagePath' => url('/uploads/users/'),
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Record Not Found!',
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }

    // Search user agents by name with user_role = 10
    public function getuseragent($title)
    {
        try {
            $users = User::with('roles.permissions')
                ->where('name', 'like', '%' . $title . '%')
                ->where('user_role', '10')
                ->get();

            if (isset($users[0])) {
                return response()->json([
                    'status' => 200,
                    'users' => $users,
                    'imagePath' => url('/uploads/users/'),
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Record Not Found!',
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }

    // Register new user with optional answers to questions
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'user_role' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

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
            'agent_id' => $request->agent_id ?? null,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        if (isset($request->answers) && is_array($request->answers)) {
            $dataArray = [];

            foreach ($request->answers as $answer) {
                $dataArray[] = [
                    'user_id' => $user->id,
                    'question_id' => $answer['question_id'] ?? '',
                    'anwser' => $answer['answer_id'] ?? '',
                    'is_custom' => $answer['isCustom'] ?? false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            AnwserRegisterQuestions::insert($dataArray);
        }

        return response()->json([
            'access_token' => $token,
            'user_role' => roles::find($user->user_role)->role_name ?? '',
            'token_type' => 'Bearer',
            'user_id' => $user->id,
            'message' => 'User Created Successfully!'
        ]);
    }

    // User login
    public function login(Request $request)
    {
        if (empty($request->email) || empty($request->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => 'Username & Password are required',
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 422);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user_id' => $user->id,
            'role_id' => (int)$user->user_role,
            'role_name' => User::with('roles')->where('id', $user->id)->first()->roles->role_name ?? '',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // Check user login existence by email
    public function checkuserlogin(Request $request)
    {
        if (empty($request->email)) {
            return response()->json([
                'status' => 'error',
                'errors' => 'Email is required',
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'user_id' => $user->id,
                'role_id' => (int)$user->user_role,
                'role_name' => User::with('roles')->where('id', $user->id)->first()->roles->role_name ?? '',
            ]);
        } else {
            return response()->json([
                'message' => 'No Email Found!',
            ]);
        }
    }

    // --- OTP Password Reset Flow ---

    // Send 4-digit OTP to user email for password reset
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        $otp = mt_rand(1000, 9999);
        $expiresAt = Carbon::now()->addMinutes(10);

        PasswordOtp::where('email', $request->email)->delete();

        PasswordOtp::create([
            'email' => $request->email,
            'otp' => $otp,
            'expires_at' => $expiresAt,
        ]);

        // Send OTP via email
        Mail::to($request->email)->send(new OtpMail($otp));

        return response()->json([
            'message' => 'OTP sent successfully',
        ]);
    }


    // Verify the OTP entered by the user
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $otpRecord = PasswordOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        if (Carbon::now()->gt($otpRecord->expires_at)) {
            return response()->json(['message' => 'OTP expired'], 400);
        }

        PasswordOtp::where('email', $request->email)->delete();

        return response()->json(['message' => 'OTP verified successfully']);
    }

    // Reset password after OTP verification
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed', // expects password_confirmation field
        ]);
        // dd($request);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        PasswordOtp::where('email', $request->email)->delete();

        return response()->json(['message' => 'Password reset successful']);
    }

    // Change password while logged in
    public function changepassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string',
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User not found',
                ]);
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Current password is incorrect',
                ]);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'Password changed successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'error' => $th->getMessage(),
            ]);
        }
    }

    // Update user profile (by user id)
    public function profileupdate(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ]);
        }

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $id,
            // Add more validation rules as needed for profile fields
        ]);

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/users/'), $filename);
            $user->profile_image = $filename;
        }

        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->email) {
            $user->email = $request->email;
        }

        // Add any other fields you want to update here...

        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Profile updated successfully',
            'user' => $user,
        ]);
    }
}
