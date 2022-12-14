<?php

namespace App\Services;

use App\Models\Destination;
use App\Services\Service;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class DestinationService extends Service
{
    /**
     * The model class of the service.
     *
     * @var string
     */
    public $model = Destination::class;

    /**
     * Retrieve a listing of the resource
     * based on request parameters.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list ()
    {
        return Cache::remember("destinations/q{$this->params->q}", config('cache.seconds', 172800), function () {
            $query = $this->model()->with('tags')
                ->activeOnly()
                ->search($this->params->q)
                ->orSearch($this->params->q, 'tags', ['name']);

            $perPage = $this->params->per_page;
            $currentPage = $this->params->page;
            $skip = ($currentPage - 1) * $perPage;

            $total = $query->count();
            $items = $query->skip($skip)->take($perPage)->get();

            return new LengthAwarePaginator($items, $total, $perPage, $currentPage);
        });
    }
}
