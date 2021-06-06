<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Question;
use App\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('check-jwt')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        //
        return ReplyResource::collection($question->replies);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
        //
        $data = $request->validate([
           'body' => 'required',
        ]);
        $data['user_id'] = auth()->id();
        $reply = $question->replies()->create($data);
        return response()->success(new ReplyResource($reply), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
        return new ReplyResource($reply);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        //
        $data = $request->validate([
            'body' => 'required'
        ]);
        $reply->update($data);
        return response()->success(new ReplyResource($reply) , 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        //
        $reply->delete();
        return response('Deleted', 201);
    }
}
