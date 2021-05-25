<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
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
    public function index()
    {
        //
        return \response()->success(QuestionResource::collection(Question::latest()->get()));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'title' => '',
            'body' => '',
            'category_id' => '',
            'user_id' => ''
        ]);
        $data['slug'] = Str::slug($data['title']);
//        auth()->user()->questions()->create($data);
        Question::create($data);
        return \response()->success('Created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
        return \response()->success(new QuestionResource($question));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
        $data = $request->validate([
            'title' => '',
            'body' => '',
            'category_id' => '',
            'user_id' => ''
        ]);
        $data['slug'] = Str::slug($data['title']);
        $question->update($data);
        return \response()->success($question, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        $question->delete();
        return response()->success(null,Response::HTTP_NO_CONTENT);
    }
}
