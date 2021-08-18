<?php

namespace App\Http\Resources;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = Answer::class;

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'body' => $this->body,
            'user' => new UserResource($this->user),
            'question' => new QuestionResource($this->question),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
