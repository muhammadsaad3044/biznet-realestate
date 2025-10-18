<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuccessStories;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SuccessStoriesController extends Controller
{
    public function index(Request $request){
        try {
            
            $stories = SuccessStories::all();   

            if($stories){
                return response()->json([
                    'status'=>200,
                    'success_stories'=>$stories,
                    'imagePath'=>url('/uploads/stories/'),
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
                'name' => 'required',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $stories = new SuccessStories();
            $stories->name = $request->name;
            $stories->role = $request->role;
            $stories->desc = $request->desc;
         
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/stories/', $filename);
                $stories->image = $filename;
            }
          
            $stories->save();
            
            
            if($stories){
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
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $stories =  SuccessStories::find($id);

            if(!$stories){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $stories->name = $request->name;
                $stories->role = $request->role;
                $stories->desc = $request->desc;
             
                if ($request->hasfile('image')) {

                    if ($stories->image && file_exists(public_path('uploads/stories/' . $stories->image))) {
                        unlink(public_path('uploads/stories/' . $stories->image));
                    }

                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/stories/', $filename);
                    $stories->image = $filename;
                }
    
                $stories->save();

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
            $stories =  SuccessStories::find($id);
       
            if($stories){
            
            if ($stories->image && file_exists(public_path('uploads/stories/' . $stories->image))) {
                unlink(public_path('uploads/stories/' . $stories->image));
            }
            
            
            $stories->delete();
            
            
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
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }
}
