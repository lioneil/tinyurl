<?php

namespace App\Services;

use App\Models\Destination;
use App\Services\Service;
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
            return $this->model()
                ->activeOnly()
                ->search($this->params->q)
                ->paginate($this->params->per_page);
        });
    }
}
