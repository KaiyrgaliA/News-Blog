<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetRubricResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at
        ];
        if ($this->childrenWith)
        {
            $data['children'] = self::collection($this->childrenWith);
        }
        if($this->news)
        {
            $data['news'] = GetNewsResource::collection($this->news);
        }
        return $data;
    }
}
