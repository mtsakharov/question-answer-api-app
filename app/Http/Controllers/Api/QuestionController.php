<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreQuestionRequest;
use App\Http\Requests\Question\UpdateQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse|object
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort') ?? 'DESC';
        $answers = Question::all()
            ->sortBy('id', $sort)
            ->paginate(10);

        return response()
            ->json(QuestionResource::collection($answers))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreQuestionRequest  $request
     * @return JsonResponse|object
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create($request->all());
        return response()
            ->json(new QuestionResource($question))
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Question  $question
     * @return JsonResponse|object
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return response()
            ->json(new QuestionResource($question))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateQuestionRequest  $request
     * @param  Question  $question
     * @return JsonResponse|object
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question = $question->update($request->all());
        return response()
            ->json(new QuestionResource($question))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Question  $question
     * @return JsonResponse|object
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()
            ->json('Question successfully deleted')
            ->setStatusCode(Response::HTTP_OK);
    }
}
