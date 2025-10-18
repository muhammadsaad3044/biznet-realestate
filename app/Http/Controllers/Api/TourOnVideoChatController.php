<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourViaVideoChat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;

class TourOnVideoChatController extends Controller
{
    public function index(){
        try {
            
            $TourViaVideoChat = TourViaVideoChat::get();   

            if($TourViaVideoChat){
                return response()->json([
                    'status'=>200,
                    'tour_on_video_chat'=>$TourViaVideoChat,
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
    
    public function user_index($id){
        try {
            
            $TourViaVideoChat = TourViaVideoChat::where('user_id', $id)->get();   

            if($TourViaVideoChat){
                return response()->json([
                    'status'=>200,
                    'tour_on_video_chat'=>$TourViaVideoChat,
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

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'p_id' => 'required|exists:products,id',
                'user_id' => 'required|exists:users,id',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $dataArray = [
                'p_id' => $request->p_id,
                'user_id'=> $request->user_id,
                'date'=> $request->date,
                'time'=> $request->time,
                'backup_date'=> $request->backup_date,
                'backup_time'=> $request->backup_time,
                'join_us_through'=> $request->join_us_through,
                'prefer_video_chat_app'=> $request->prefer_video_chat_app,
                'id_or_number'=> $request->id_or_number,
                'prefer_backup_date'=> $request->prefer_backup_date,
                'prefer_backup_time'=> $request->prefer_backup_time,
                'prefer_backup_date_1'=> $request->prefer_backup_date_1,
                'prefer_backup_time_1'=> $request->prefer_backup_time_1,
                'prefer_backup_date_2'=> $request->prefer_backup_date_2,
                'prefer_backup_time_2'=> $request->prefer_backup_time_2,
                'firstname'=> $request->firstname,
                'lastname'=> $request->lastname,
                'phone'=> $request->phone,
                'notes'=> $request->notes,
                'working_as_realstate_agent'=> $request->working_as_realstate_agent,
                'agreement_committing_to_work_with_agent'=> $request->agreement_committing_to_work_with_agent,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            TourViaVideoChat::insert($dataArray);
            
    
            return response()->json([
                'status' => 200,
            ], 200);
    
        } catch (\Throwable $th) {
            
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'cat_id' => 'required|exists:categories,id',
                'sub_title' => 'required',
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // CHeck If the Record exists of not 

            $dataexist = TourViaVideoChat::find($id);

            if($dataexist){

                $dataArray = [
                    'p_id' => $request->p_id,
                    'user_id'=> $request->user_id,
                    'date'=> $request->date,
                    'time'=> $request->time,
                    'backup_date'=> $request->backup_date,
                    'backup_time'=> $request->backup_time,
                    'join_us_through'=> $request->join_us_through,
                    'prefer_video_chat_app'=> $request->prefer_video_chat_app,
                    'id_or_number'=> $request->id_or_number,
                    'prefer_backup_date'=> $request->prefer_backup_date,
                    'prefer_backup_time'=> $request->prefer_backup_time,
                    'prefer_backup_date_1'=> $request->prefer_backup_date_1,
                    'prefer_backup_time_1'=> $request->prefer_backup_time_1,
                    'prefer_backup_date_2'=> $request->prefer_backup_date_2,
                    'prefer_backup_time_2'=> $request->prefer_backup_time_2,
                    'firstname'=> $request->firstname,
                    'lastname'=> $request->lastname,
                    'phone'=> $request->phone,
                    'notes'=> $request->notes,
                    'working_as_realstate_agent'=> $request->working_as_realstate_agent,
                    'agreement_committing_to_work_with_agent'=> $request->agreement_committing_to_work_with_agent,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
    
                TourViaVideoChat::update($dataArray);
                
        
                return response()->json([
                    'status' => 200,
                ], 200);

            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Record Not Found',
                ], 200);
            }
    

    
        } catch (\Throwable $th) {
            // Log the exception message
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function destory(Request $request, $id){
        try {
            
            $TourViaVideoChat = TourViaVideoChat::find($id);
            
            if($TourViaVideoChat){
                
                $TourViaVideoChat->delete();
                    
                return response()->json([
                    'status'=>200,
                    'message'=>'Deleted Successfully!',
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
