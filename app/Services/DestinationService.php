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
        Cache::forget("destinations/q{$this->params->q}");
        return Cache::remember("destinations/q{$this->params->q}", config('cache.seconds', 172800), function () {
            $query = $this->model()->activeOnly()->search($this->params->q);

            $perPage = $this->params->per_page;
            $currentPage = $this->params->page;
            $skip = ($currentPage - 1) * $perPage;

            $total = $query->count();
            $items = $query->skip($skip)->take($perPage)->get();

            return new LengthAwarePaginator($items, $total, $perPage, $currentPage);
        });
    }
}
