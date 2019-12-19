<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Profanity;
use App\Comment;
use App\Post;

class CommentController extends Controller
{

    function validateUpdateRequest($request) {
        return $validatedData = $request->validate([
            'text' => 'required|max:500',
        ]);
    }

    function validateStoreRequest($request) {
        return $validatedData = $request->validate([
            'text' => 'required|max:500',
            'post_id' => 'required',
            'user_id' => 'required',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apiIndexByPost($id)
    {
        $comments = Comment::where('post_id', $id)->get();
        $comments->load('user');
        return $comments;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apiStore(Request $request, Profanity $p)
    {

        $request = $this->validateStoreRequest($request);

        $profanity = $p->checkProfanity($request['text']);

        $profanity = (string) $profanity->getBody();
        if($profanity === 'true') {
            $profanity = true;
        } else {
            $profanity = false;
        }

        if($profanity) {
            $errors = array(
                'error' => 'Profanity detected'
            );
            return response($errors,400);
        }

        $c = new Comment;
        $c->text = $request['text'];
        $c->post_id = $request['post_id'];
        $c->user_id = $request['user_id'];
        $c->save();
        $c->load('user');

        return $c;
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
    public function edit($id)
    {
       
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

        $profanity = $p->checkProfanity($request['text']);

        $profanity = (string) $profanity->getBody();
        if($profanity === 'true') {
            $profanity = true;
        } else {
            $profanity = false;
        }

        if($profanity) {
            $errors = array(
                'error' => 'Profanity detected'
            );
            return $errors;
        }

        $comment = Comment::findOrFail($id);
        $comment->text = $request['text'];
        $comment->save();

        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
