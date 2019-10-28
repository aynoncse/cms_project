<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Category;
use App\Post;
use App\Tag;

class PostsController extends Controller
{
    public function __construct(){
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        //Upload the image to storage
        $image = $request->image->store('posts');

        //Create the post
        $post = Post::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'content'       => $request->content,
            'image'         => $image,
            'published_at'  => $request->published_at,
            'category_id'   => $request->category,
            'user_id'       => auth()->user()->id,
        ]);

        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }
        //Flash message
        session()->flash('success', 'Post created successfully');

        //redirect user
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'published_at', 'content']);
        //Check if new image
        if ($request->hasFile('image')) {
            //Upload it
            $image = $request->image->store('posts');
            //Delete old one
            $post->deleteImage();

            $data['image'] = $image;
        }

        //Check if post have tags then attach the newer tags and detach the older tags
        if ($request->tags) {
            $post->tags()->sync($request->tags);
        }
        
        //Update attributes
        $post->update($data);

         //Flash message
        session()->flash('success', 'Post updated successfully');

        //Redirect user
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        //Delete Post

        if($post->trashed()){
            $post->deleteImage();
            $post->forceDelete();
        }else{
            $post->delete();
        }

         //Flash message
        session()->flash('success', 'Post deleted successfully');

        //redirect user
        return redirect(route('posts.index'));
    }

    /**
     * Display a list of trahsed posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        //Get all trashed posts
        $trahsed = Post::onlyTrashed()->get();

        return view('posts.index')->with('posts', $trahsed);
    }

    public function restore($id)
    {
        //Get the trashed post
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        //Restore the post
        $post->restore();

        //Flash Message
        session()->flash('success', 'Post restored successfully');

        //redirect user
        return redirect()->back();
    }
}
