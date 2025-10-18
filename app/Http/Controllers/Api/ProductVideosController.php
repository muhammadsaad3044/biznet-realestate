<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{ProductVideos};
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ProductVideosController extends Controller
{
    public function index(Request $request){
        try {
            
            $product = ProductVideos::all();   

            if($product){
                return response()->json([
                    'status'=>200,
                    'products'=>$product,
                    'imagePath'=>url('/uploads/products/videos/'),
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

    public function store(Request $request) {
        try {
            
            $validator = Validator::make($request->all(), [
                'p_id' => 'required|exists:products,id',
               'video' => 'required', 
               'video.*' => 'mimes:mp4,avi,mkv,flv',
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Retrieve the video files
            $videos = $request->file('video');
            
            // Ensure $videos is an array
            $videos = is_array($videos) ? $videos : [$videos];
                        
        
            if (!empty($videos)) {
            
                foreach ($videos as $index => $file) {
            
                    $video = "";
    
                    if ($file instanceof \Illuminate\Http\UploadedFile) {
                        
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . $index . '.' . $extension;
                        $file->move('uploads/products/videos/', $filename);
                        $video = $filename; // Save the filename
                    }
    
                    // Store the video information in the database
                   
                    $dataArray = [
                        'p_id' => $request->p_id,
                        'video' => $video,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
    
                     
                    ProductVideos::insert($dataArray);
                }
                
                return response()->json([
                    'status' => 200,
                    'message' => 'Store Videos Successfully!',
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No video files found!',
                ], 404); 
            }
    
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }
    

    public function update(Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), [
                'p_id' => 'required|exists:products,id',
                'video' => 'mimes:mp4,avi,mkv,flv', 
            ]);
    
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $product = ProductVideos::find($id);
    
            if (!$product) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Record Not Found!',
                ], 404);  
            } else {
                $product->pd_id = $request->pd_id;
    
                if ($request->hasFile('video')) {
                    $file = $request->file('video');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/products/videos/', $filename);
                    $product->video = $filename; // Save the filename to the video column
                }
    
                $product->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Video updated successfully!',
                ], 200);
            }
    
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'status' => 400,
            ], 400);
        }
    }
    

    public function destory(Request $request, $id) {
        try {
            $product = ProductVideos::find($id);
    
            if ($product) {
                $filePath = 'uploads/products/videos/' . $product->video;
    
                // Check if the file exists in the storage
                if (Storage::exists($filePath)) {
                    // Delete the file from the storage
                    Storage::delete($filePath);
                }

    
                // Delete the record from the database
                $product->delete();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Video deleted successfully!',
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
    
}
