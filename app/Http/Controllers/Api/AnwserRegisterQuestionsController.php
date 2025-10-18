<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnwserRegisterQuestions;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Jobs\SendMatchNotification;
use DB;

class AnwserRegisterQuestionsController extends Controller
{
    
    
    public function index($id){
        try {
            
            $answer = AnwserRegisterQuestions::where('user_id', $id)->first();   

            if($answer){
                return response()->json([
                    'status'=>true,
                ], 200);

            }else{
                return response()->json([
                    'status'=>false,
                  
                ], 404);  
            }
        } catch (\Throwable $th) {

            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);

        }
        
    }
    
    public function getsimilarusers($userId){
        try {
            
        $similar_users = DB::table('anwser_register_questions as t1')
                        ->select('t2.user_id', 'users.name', 'users.email', DB::raw('COUNT(*) as match_count'))
                        ->join('anwser_register_questions as t2', function ($join) use ($userId) {
                            $join->on('t1.question_id', '=', 't2.question_id')
                                 ->on('t1.anwser', '=', 't2.anwser')
                                 ->where('t1.user_id', '=', $userId)
                                 ->where('t2.user_id', '<>', $userId);
                        })
                        ->join('users', 't2.user_id', '=', 'users.id')
                        ->groupBy('t2.user_id', 'users.name', 'users.email')
                        ->having('match_count', '>', 5)
                        ->orderByDesc('match_count')
                        ->get();

            if($similar_users){
                
                // Send Email to New User Matches
                $currentUser = DB::table('users')->find($userId);
            
                foreach ($similar_users as $matchedUser) {
                    $existingMatch = DB::table('user_matches')
                        ->where(function ($query) use ($userId, $matchedUser) {
                            $query->where('user_id', $userId)
                                  ->where('matched_user_id', $matchedUser->user_id);
                        })
                        ->orWhere(function ($query) use ($userId, $matchedUser) {
                            $query->where('user_id', $matchedUser->user_id)
                                  ->where('matched_user_id', $userId);
                        })
                        ->exists();
            
                    if (!$existingMatch) {
                        // Record the match
                        DB::table('user_matches')->insert([
                            ['user_id' => $userId, 'matched_user_id' => $matchedUser->user_id],
                            ['user_id' => $matchedUser->user_id, 'matched_user_id' => $userId],
                        ]);
            
                        // Notify the current user about the match
                        SendMatchNotification::dispatch($currentUser->email, [$matchedUser]);
            
                        // Notify the matched user about the match
                        SendMatchNotification::dispatch($matchedUser->email, [
                            ['user_id' => $currentUser->id, 'name' => $currentUser->name]
                        ]);
                    }
                }

                return response()->json([
                    'status'=>true,
                    'similar_users' => $similar_users,
                ], 200);

            }else{
                return response()->json([
                    'status'=>false,
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
                'user_id' => 'required|exists:users,id',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            
            if (isset($request->question_id) && !empty($request->question_id[0])) {
                $count = count($request->question_id);
                $dataArray = [];
            
                for ($i = 0; $i < $count; $i++) {
                    $dataArray[] = [
                        'user_id' => $request->user_id,
                        'question_id' => $request->question_id[$i] ?? '', 
                        'anwser' => $request->anwser_id[$i] ?? '', 
                        'created_at' => now(), 
                        'updated_at' => now(),
                    ];
                }
            
                try {
                    // Batch insert
                    $inserted = AnwserRegisterQuestions::insert($dataArray);
            
                    if ($inserted) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Added Successfully!',
                        ], 200);
                    } else {
                        throw new \Exception('Insert operation failed');
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Something went wrong!',
                        'error' => $e->getMessage(), // Optional: Detailed error for debugging
                    ], 200);
                }
            }



        } catch (\Throwable $th) {

            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }

}
