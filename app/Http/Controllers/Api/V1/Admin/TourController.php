<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

class TourController extends Controller
{
    /**
     * Save a travel for a tour
     */
    public function store(Travel $travel, TourRequest $request): TourResource
    {
        $tour = $travel->tours()->create($request->validated());

        return new TourResource($tour);
    }
}
