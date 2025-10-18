<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BannerController extends Controller
{
    public function index(Request $request){
        try {
            
            $banner = Banner::all();   

            if($banner){
                return response()->json([
                    'status'=>200,
                    'banners'=>$banner,
                    'imagePath'=>url('/uploads/banners/'),
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
                'title' => 'required|string|unique:banners',
                'price' => 'required',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $banner = new Banner();
            $banner->title = $request->title;
            $banner->desc = $request->desc;
            $banner->price = $request->price;
            $banner->location = $request->location;
         
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/banners/', $filename);
                $banner->image = $filename;
            }
            
            $banner->save();
            
            
            if($banner){
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
                'price' => 'required',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $banner =  Banner::find($id);

            if(!$banner){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $banner->title = $request->title;
                $banner->desc = $request->desc;
                $banner->price = $request->price;
                $banner->location = $request->location;
    
                if ($request->hasfile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/banners/', $filename);
                    $banner->image = $filename;
                }
    
                $banner->save();

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
            $banner =  Banner::find($id);
       
        
            if($banner){
                                
            $banner->delete();
            
            
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
