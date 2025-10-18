<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogs;
use App\Models\BlogsImages;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BlogImagesController extends Controller
{
    public function index(Request $request){
        try {
            
            $blogimages = BlogsImages::get();   

            if($blogimages){
                return response()->json([
                    'status'=>200,
                    'blogimages'=> $blogimages,
                    'imagePath'=>url('/uploads/blogs/'),
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
                'blog_id' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $blogimages = new BlogsImages();
            $blogimages->blog_id = $request->blog_id;
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/blogs/', $filename);
                $blogimages->image = $filename;
            }
            $blogimages->save();
            
            
            if($blogimages){

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
                'blog_id' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $blogimages =  BlogsImages::find($id);

            if(!$blogimages){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $blogimages->blog_id = $request->blog_id;
                if ($request->hasfile('image')) {

                    // Delete the previous image if it exists
                    if ($blogimages->image && file_exists(public_path('uploads/blogs/' . $blogimages->image))) {
                        unlink(public_path('uploads/blogs/' . $blogimages->image));
                    }

                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/blogs/', $filename);
                    $blogimages->image = $filename;
                }
                $blogimages->save();

                return response()->json([
                    'status' => 200,
                    'message'=>'Update Successfully!',
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

            $blogimages =  BlogsImages::find($id);
    
            if($blogimages){

            // Delete the previous image if it exists
            
            if ($blogimages->image && file_exists(public_path('uploads/blogs/' . $blogimages->image))) {
            unlink(public_path('uploads/blogs/' . $blogimages->image));
            }    

            $blogimages->delete();

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
