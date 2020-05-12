<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;


class ArticleResource extends JsonResource
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
                  'title' =>$this->title,
                   'body' => $this->body,
                   'user' => new UserResource($this->user),
                   'created at' => $this->created_at->diffForHumans()
               ];
    } 
    
    public function with($request)
    {
        return [
                 "Api Version" => '1.0.0',
                 "Api Author"  => 'Nader'
               ];
    }
}
