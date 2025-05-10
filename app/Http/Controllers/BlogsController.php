<?php

namespace App\Http\Controllers;

use App\Models\comments;
use App\Models\posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogsController extends Controller
{
    public function index(){
        return view("blogs");
    }

    public function showPostsComments(){
        $getComments=comments::all();
        $getPosts=comments::all();

        return response()->json([$getComments,$getPosts]);
    }

    public function createPost(Request $request){
        $request->validate([
            'title'=>['required'],
            'image_url'=>['required', 'file', 'mimes:jpg,png,jpeg'],
            'short_description'=>['required'],
            'content'=>['required'],
        ]);

        if($request->hasFile('image_url')){
            $fileData=$request->file(('image_url'));

            $InsertPost=posts::create([
                'title'=>$request->title,
                'image_url'=>'Path',
                'short_description'=>$request->short_description,
                'content'=>$request->content,
            ]);
            
            $fileName = $fileData->getClientOriginalName() . time() . '.' . $fileData->getClientOriginalExtension();
            $filePath = $fileData->storeAs('uploads/post/' .'/'.$InsertPost->id.'/'.Auth::user()->id, $fileName, 'public');

            $InsertPost->image_url = $filePath;

            $InsertPost->save();

            return response()->json(['status'=>1,'message'=>'Post is created successfully.','data'=>$InsertPost]);
        }

        return response()->json(['status'=>0,'message'=>'Post is not created.']);

    }

    public function createComments(Request $request){
        $request->validate([
            'post_id'=>['required'],
            'name'=>['required'],
            'email'=>['required'],
            'message'=>['required'],
        ]);

        $InsertComment=comments::create([
            'post_id'=>$request->post_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'message'=>$request->message,
        ]);

        if(count($InsertComment)>0){
            return response()->json(['status'=>1,'message'=>'Comment is created successfully.','data'=>$InsertComment]);
        }

        return response()->json(['status'=>0,'message'=>'Comment is not created.']);   
    }

    public function updatePost(Request $request){
        $request->validate([
            'title'=>['required'],
            'image_url'=>['required', 'file', 'mimes:jpg,png,jpeg'],
            'short_description'=>['required'],
            'content'=>['required'],
        ]);

    
        if(!isset($request->id)){
             return response()->json(['status'=>0,'message'=>'Post id is invalid.']);
        }

        if(Auth::user()->role="user" && ($request->id!=Auth::user()->id)){
              return response()->json(['status'=>0,'message'=>'You did not have access to update the post.']); 
        }

        $ImagePath='';
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            if (in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg', 'png'])) {
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                    . '_' . time() . '.' . $file->getClientOriginalExtension();

                $filePath = $file->storeAs('uploads/posts/'.$request->id.'/'. Auth::user()->id, $fileName, 'public');

                if (!empty($filePath)) {
                    $ImagePath = $filePath;
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'Invalid image. Supported formats are PNG, JPG, and JPEG.']);
            }
        }

        $UpdatePost=posts::where('id','=',$request->id)->update([
            'title'=>$request->title,
            'image_url'=>$ImagePath,
            'short_description'=>$request->short_description,
            'content'=>$request->content,
        ]);

        if($UpdatePost>0){
            return response()->json(['status'=>0,'message'=>'Post is updated successfully.','UpdateStatus'=>$UpdatePost]);
        }

        return response()->json(['status'=>0,'message'=>'Post is not updated.']); 
    }

    public function updateComments(Request $request){
        $request->validate([
            'post_id'=>['required'],
            'name'=>['required'],
            'email'=>['required'],
            'message'=>['required'],
        ]);

        if(!isset($request->id)){
             return response()->json(['status'=>0,'message'=>'Comment id is invalid.']);
        }

        if(Auth::user()->role="user" && ($request->id!=Auth::user()->id)){
              return response()->json(['status'=>0,'message'=>'You did not have access to update the comment.']); 
        }

        $UpdateComment=comments::where('id','=',$request->id)->update([
            'post_id'=>$request->post_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'message'=>$request->message,
        ]);

        if($UpdateComment>0){
            return response()->json(['status'=>1,'message'=>'Comment is updated successfully.','UpdateStatus'=>$UpdateComment]);
        }

        return response()->json(['status'=>0,'message'=>'Comment is not updated.']); 
    }

    public function deletePost(Request $request){
        if(!isset($request->id)){
             return response()->json(['status'=>0,'message'=>'Post id is invalid.']);
        }

        if(Auth::user()->role="user" && ($request->id!=Auth::user()->id)){
            return response()->json(['status'=>0,'message'=>'You did not have access to delete the post.']); 
        }

        $post = posts::find($request->id);
        $deletePost=0;
        if ($post) {
            $post->comments()->delete(); // delete related comments
            $deletePost=$post->delete();             // delete the post
        }
        if($deletePost>0){
          return response()->json(['status'=>1,'message'=>'Post is deleted successfully.','UpdateStatus'=>$deletePost]);
        }

        return response()->json(['status'=>0,'message'=>'Post is not deleted.']); 
    }

    public function deleteComments(Request $request){
        if(!isset($request->id)){
             return response()->json(['status'=>0,'message'=>'Comment id is invalid.']);
        }

        if(Auth::user()->role="user" && ($request->id!=Auth::user()->id)){
              return response()->json(['status'=>0,'message'=>'You did not have access to delete the comment.']); 
        }

        $deleteComment=comments::where('id','=',$request->id)->delete();
        if($deleteComment>0){
          return response()->json(['status'=>1,'message'=>'Comment is deleted successfully.','UpdateStatus'=>$deleteComment]);
        }

        return response()->json(['status'=>0,'message'=>'Comment is not deleted.']); 
    }
}
