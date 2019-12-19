<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Profanity;
use App\Comment;
use App\Image;
use App\Post;

class PostController extends Controller
{

    function validateRequest($request) {
        return $validatedData = $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'description' => 'nullable|max:500',
        ]);
    }

    function validateUpdateRequest($request) {
        return $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:500',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(5);

        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', ['update' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Profanity $p)
    {
        $validatedData = $this->validateRequest($request);
        
        $profanity = $p->checkProfanity($validatedData['title'].$validatedData['description']);

        $profanity = (string) $profanity->getBody();
        if($profanity === 'true') {
            $profanity = true;
        } else {
            $profanity = false;
        }

        if($profanity) {
            $errors = array(
                'message' => 'Profanity detected'
            );
            return view('posts.create', ['update' => False])->withErrors($errors);
        }

        $image = $validatedData['image'];

        $a = new Post;
        $a->title = $validatedData['title'];
        $a->description = $validatedData['description'];
        $a->user_id = Auth::user()->id;
        $a->save();

        \App::call('App\Http\Controllers\ImageController@store', ['image' => $image, 'post_id' => $a->id]);

        session()->flash('message', 'Post created');

        return redirect()->route('posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = Comment::where('post_id', $id)->get();
        $userId = Auth::user()->id;

        return view('posts.show', ['post' => $post, 'user_id' => $userId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id == Auth::user()->id) {
            return view('posts.create', ['update' => true, 'post' => $post]);
        } else {
            
            session()->flash('message', 'Unauthorized');
            return redirect()->route('posts.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Profanity $p)
    {
        $request =  $this->validateUpdateRequest($request);

        $profanity = $p->checkProfanity($request['title'].$request['description']);

        $post = Post::findOrFail($id);

        $profanity = (string) $profanity->getBody();
        if($profanity === 'true') {
            $profanity = true;
        } else {
            $profanity = false;
        }

        if($profanity) {
            $errors = array(
                'message' => 'Profanity detected'
            );
            return view('posts.create', ['update' => true, 'post' => $post])->withErrors($errors);
        }

        $post->title = $request['title'];
        $post->description = $request['description'];
        $post->save();
        $userId = Auth::user()->id;

        return redirect()->route('posts.show', ['id' => $post->id])
            ->with('message', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $id)
    {
        $post = Post::findOrFail($id);

        if($post->user_id == $userId) {
            $post->delete();
            return redirect()->route('posts.index')->with('message', 'Post Deleted');
        }

        return redirect()->route('posts.index')->with('message', 'Unauthorized to delete');
    }
}
