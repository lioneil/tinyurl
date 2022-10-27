<?php

namespace App\Models;

use App\Enums\DestinationStatus;
use App\Models\Traits\HasSearch;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasFactory, HasSearch, SoftDeletes;

    /**
     * Searchable columns.
     *
     * @var array
     */
    public $searchableColumns = ['url', 'alias'];


    /**
     * Scope a query to search through columns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function scopeActiveOnly (Builder $query)
    {
        return $query->where('status', DestinationStatus::ACTIVE);
    }
}
