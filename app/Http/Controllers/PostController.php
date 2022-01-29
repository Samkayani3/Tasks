<?php

namespace App\Http\Controllers;
use App\Models\posts;
use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('order','ASC')->simplePaginate(8);

        return view('task',compact('posts'));
    }

    public function AddTask(Request $req){
        $post = new Post;
        $post->title=$req->name;
        $post->save();
        return redirect('/');
    }

    public function update(Request $request)
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['order' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);
    }

    public function editpost($id){
        $posts = Post::where(['id'=>$id])->first();
        return view('edit-post')->with(compact('posts'));
    }

    public function updateTask(Request $request, $id)
    {
        
        $tasks = Post::findOrFail($id);
        $tasks->title = $request->name;
        // $tasks->update($request->all());
        $tasks->update();
        return redirect('/');
    }

    public function deleteTask($id){

        $task = Post::find($id);
        $task->delete();
        return redirect('/')->with('msg','Task Deleted Successfully');
 
     }
}