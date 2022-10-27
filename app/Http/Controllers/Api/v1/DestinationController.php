<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DestinationResource;
use App\Services\DestinationService;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Retrieve a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\DestinationService $destination
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request, DestinationService $destination)
    {
        return DestinationResource::collection($destination->params($request->all())->list());
    }
}
