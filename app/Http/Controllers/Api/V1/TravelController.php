<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelController extends Controller
{
    /**
     * Get All public travels
     *
     * @unauthenticated
     */
    public function index(): JsonResource
    {
        $travels = Travel::where('is_public', true)->paginate();

        return TravelResource::collection($travels);
    }
}
