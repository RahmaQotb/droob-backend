<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'exam_id' => $this->exam_id,
            'type' => $this->type,
            'text' => $this->text,
            'image' => $this->image,
            'parent_question_id' => $this->parent_question_id,
            'answers' => AnswerResource::collection($this->whenLoaded('answers')), // إذا كانت العلاقة محملة
        ];
    }
}