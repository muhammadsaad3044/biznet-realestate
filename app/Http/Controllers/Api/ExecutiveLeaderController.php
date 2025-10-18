<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExecutiveLeadership;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ExecutiveLeaderController extends Controller
{
    public function index(Request $request){
        try {
            
            $leaders = ExecutiveLeadership::all();   

            if($leaders){
                return response()->json([
                    'status'=>200,
                    'leaders'=>$leaders,
                    'imagePath'=>url('uploads/leaders/'). '/',
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

    public function store(Request $request){
        try {
        
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif',
                'description' => 'required|max:1000',

            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $leaders = new ExecutiveLeadership();
            $leaders->title = $request->title;
            $leaders->role = $request->role;
            $leaders->description = $request->description;
        
         
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/leaders/', $filename);
                $leaders->image = $filename;
            }
            
            $leaders->save();
            
            
            if($leaders){
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

    public function update(Request $request, $id){
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif',
                   'description' => 'required|max:1000',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $leaders =  ExecutiveLeadership::find($id);

            if(!$leaders){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $leaders->title = $request->title;
                $leaders->role = $request->role;
                $leaders->description = $request->description;
                
    
                if ($request->hasfile('image')) {

                    if ($leaders->image && file_exists(public_path('uploads/leaders/' . $leaders->image))) {
                        unlink(public_path('uploads/leaders/' . $leaders->image));
                    }
                    
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/leaders/', $filename);
                    $leaders->image = $filename;
                }
    
                $leaders->save();

                return response()->json([
                    'status' => 200,
                ], 200);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }

    public function destory(Request $request, $id){
        
        try {
            $leaders =  ExecutiveLeadership::find($id);
       
        
            if($leaders){

                if ($leaders->image && file_exists(public_path('uploads/leaders/' . $leaders->image))) {
                    unlink(public_path('uploads/leaders/' . $leaders->image));
                }

            $leaders->delete();
            
            
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
