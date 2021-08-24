<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'name' => $this->name,
            'author' => $this->author,
            'ISBN' => $this->ISBN,
            'description' => $this->description,
            'originalCount' => $this->originalCount,
            'count' => $this->count,
            'image' => $this->image,
            'publishedDate' => $this->publishedDate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
