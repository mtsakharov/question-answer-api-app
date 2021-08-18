<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return response()
            ->json(TagResource::collection($tags))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTagRequest  $request
     * @return JsonResponse|object
     */
    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->all());
        return response()
            ->json(new TagResource($tag))
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Tag  $tag
     * @return JsonResponse|object
     */
    public function show(Tag $tag)
    {
        $tag->increment('views');
        return response()
            ->json(new TagResource($tag))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTagRequest  $request
     * @param  Tag  $tag
     * @return JsonResponse|Response|object
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag = $tag->update($request->all());
        return response()
            ->json(new TagResource($tag))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag  $tag
     * @return JsonResponse|object
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()
            ->json('Tag successfully deleted')
            ->setStatusCode(Response::HTTP_OK);
    }
}
