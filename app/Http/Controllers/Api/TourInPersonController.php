<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourInPerson;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TourInPersonController extends Controller
{
    public function index(){
        try {
            
            $tourinperson = TourInPerson::with('user')->get();   

            if($tourinperson){
                return response()->json([
                    'status'=>200,
                    'tour_in_person'=>$tourinperson,
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
            
            $tourinperson = TourInPerson::with('user')->where('user_id', $id)->get();   

            if($tourinperson){
                return response()->json([
                    'status'=>200,
                    'tour_in_person'=>$tourinperson,
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
                'phone' => 'required',
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
                'not_sure_about_this_schedule'=> $request->not_sure_about_this_schedule,
                'firstname'=> $request->firstname,
                'lastname'=> $request->lastname,
                'email'=> $request->email,
                'phone'=> $request->phone,
                'notes'=> $request->notes,
                'financing_options'=> $request->financing_options,
                'working_as_realstate_agent'=> $request->working_as_realstate_agent,
                'best_way_to_contact'=> $request->best_way_to_contact,
                'agreement_committing_to_work_with_agent'=> $request->agreement_committing_to_work_with_agent,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            TourInPerson::insert($dataArray);
            
    
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

            $dataexist = TourInPerson::find($id);

            if($dataexist){

                $dataArray = [
                    'p_id' => $request->p_id,
                    'user_id'=> $request->user_id,
                    'date'=> $request->date,
                    'not_sure_about_this_schedule'=> $request->not_sure_about_this_schedule,
                    'firstname'=> $request->firstname,
                    'lastname'=> $request->lastname,
                    'email'=> $request->email,
                    'phone'=> $request->phone,
                    'notes'=> $request->notes,
                    'financing_options'=> $request->financing_options,
                    'working_as_realstate_agent'=> $request->working_as_realstate_agent,
                    'best_way_to_contact'=> $request->best_way_to_contact,
                    'agreement_committing_to_work_with_agent'=> $request->agreement_committing_to_work_with_agent,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
    
                TourInPerson::update($dataArray);
                
        
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
            
            $tourinperson = TourInPerson::find($id);
            
            if($tourinperson){
                
                $tourinperson->delete();
                    
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
