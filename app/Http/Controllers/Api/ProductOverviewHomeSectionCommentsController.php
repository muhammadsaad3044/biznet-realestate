<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ProductNeighborhoodCommentSection};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ProductOverviewHomeSectionCommentsController extends Controller
{
    public function index(Request $request){
        try {
            
            $comments = ProductNeighborhoodCommentSection::get();   

            if($comments){
                return response()->json([
                    'status'=>200,
                    'overview_neighborhood_section_comments'=>$comments,
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
            
            $comments = ProductNeighborhoodCommentSection::where('user_id', $id)->get();   

            if($comments){
                return response()->json([
                    'status'=>200,
                    'overview_neighborhood_section_comments'=>$comments,
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
                'p_id' => 'required|exists:products,id',
                'user_id' => 'required|exists:users,id',
                'comment' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $comments = new ProductNeighborhoodCommentSection();
            $comments->p_id = $request->p_id;
            $comments->user_id = $request->user_id;
            $comments->comment = $request->comment;
            $comments->save();
            
            
            if($comments){
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
                'p_id' => 'required|exists:products,id',
                'user_id' => 'required',
                'comment' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $comments =  ProductNeighborhoodCommentSection::find($id);

            if(!$comments){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $comments->p_id = $request->p_id;
                $comments->user_id = $request->user_id;
                $comments->comment = $request->comment;
                $comments->save();

                return response()->json([
                    'status' => 200,
                    'message'=>' Upodate Successfully!',
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
            $comments =  ProductNeighborhoodCommentSection::find($id);
       
        
            if($comments){
                         
            $comments->delete();

            return response()->json([
                'status' => 200,
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
