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

class BlogsController extends Controller
{
    public function index(Request $request){
        try {
            
            $blogs = Blogs::with('images')->get();   

            if($blogs){
                return response()->json([
                    'status'=>200,
                    'blogs'=> $blogs,
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
    
    
    
    public function getlatestblog(Request $request){
        try {
            
            $blogs = Blogs::with('images')->take(5)->latest('id')->get();   

            if($blogs){
                return response()->json([
                    'status'=>200,
                    'blogs'=> $blogs,
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
    
    
    public function getfeatureblog(Request $request){
        try {
            
            $blogs = Blogs::with('images')->where('feature_blog', 'yes')->get();   

            if($blogs){
                return response()->json([
                    'status'=>200,
                    'blogs'=> $blogs,
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
    
    public function getsingleblog(Request $request, $id){
        try {
            
            $blogs = Blogs::with('images')->where('id', $id)->first();   

            if($blogs){
                return response()->json([
                    'status'=>200,
                    'blogs'=> $blogs,
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
                'title' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $blogs = new Blogs();
            $blogs->title = $request->title;
            $blogs->feature_blog = isset($request->feature_blog) ? 'yes' : 'no';
            $blogs->desc = $request->desc;
            $blogs->save();
            
            
            if($blogs){
            // Save Blogs Images
            // $images = $request->file('image', []);
            $images = $request->image;


            foreach ($images as $index => $file) {
                    
                $image = "";
                
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $extension = $file->getClientOriginalExtension(); 
                    $filename = time() . $index . '.' . $extension;
                    $file->move('uploads/blogs/', $filename);
                    $image = $filename; // Save the filename
                }
    
                // Store the image and corresponding video (or null if no video)
                $dataArray = [
                    'blog_id' => $blogs->id,
                    'image' => $image,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                
                BlogsImages::insert($dataArray);

            }

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
                'title' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $blogs =  Blogs::find($id);

            if(!$blogs){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                
                $blogs->title = $request->title;
                $blogs->feature_blog = isset($request->feature_blog) ? 'yes' : 'no';
                $blogs->desc = $request->desc;
                $blogs->save();

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

            $blogs =  Blogs::find($id);
    
            if($blogs){
                      
            $blogs->delete();

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
