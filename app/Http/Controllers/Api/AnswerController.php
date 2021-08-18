<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Answer\StoreAnswerRequest;
use App\Http\Requests\Answer\UpdateAnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|object
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort') ?? 'DESC';
        $answers = Answer::all()
            ->sortBy('id', $sort)
            ->paginate(10);

        return response()
            ->json(AnswerResource::collection($answers))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAnswerRequest  $request
     * @return JsonResponse|object
     */
    public function store(StoreAnswerRequest $request)
    {
        $answer = Answer::create($request->all());
        return response()
            ->json(new AnswerResource($answer))
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Answer  $answer
     * @return JsonResponse|object
     */
    public function show(Answer $answer)
    {
        $answer->increment('views');
        return response()
            ->json(new AnswerResource($answer))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAnswerRequest  $request
     * @param  Answer  $answer
     * @return JsonResponse|object
     */
    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        $answer->update($request->all());
        return response()
            ->json(new AnswerResource($answer))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Answer  $answer
     * @return JsonResponse|object
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return response()
            ->json('Answer successfully deleted')
            ->setStatusCode(Response::HTTP_OK);
    }
}
