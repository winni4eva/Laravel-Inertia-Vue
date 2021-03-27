<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(request()->headers->get('authorization')) {
            return $this->apiTemplate();
        } else {
            return $this->viewTemplate();
        }
    }

    protected function viewTemplate() {
        return [
            '@id'   => route('companies.show', $this->resource, false),
            '@type' => 'Company',
            '@canEdit' => Auth::check() ? Auth::user()->is_admin : false,
            '@canDelete' => Auth::check() ? Auth::user()->is_admin : false,
            'name'  => $this->resource->name,
            'phone' => $this->resource->phone,
            'url'   => $this->resource->url,
            'email' => $this->resource->email,
            'rating' => $this->resource->rating,
            'rating_count' => $this->resource->ratingCount,
            'user_rating' => $this->resource->userRating ?: null
        ];
    }

    protected function apiTemplate() {
        return [
            'id'   => $this->resource->id,
            'type' => 'Company',
            'name'  => $this->resource->name,
            'phone' => $this->resource->phone,
            'url'   => $this->resource->url,
            'email' => $this->resource->email,
            'rating' => $this->resource->rating,
            'rating_count' => $this->resource->ratingCount
        ];
    }
}
