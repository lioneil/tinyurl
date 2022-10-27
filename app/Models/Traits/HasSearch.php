<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait HasSearch
{
    /**
     * Unsearchable columns.
     *
     * @var array
     */
    public $unsearchableColumns = ['id', 'updated_at', 'created_at'];

    /**
     * Cleanup columns and remove unsearchable fields.
     *
     * @param array $columns
     * @return array
     */
    function sanitizeSearchableColumns (array $columns)
    {
        return collect($columns)->reject(function ($v, $column) {
            return in_array($column, $this->unsearchableColumns);
        })->toArray();
    }

    /**
     * Scope a query to search through columns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function scopeSearch (Builder $query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($builder) use ($search) {
            if (str_contains($search, "\"")) {
                // Case-sensitive search
                foreach ($this->searchableColumns as $column) {
                    $builder->orWhere($column, trim($search, '"'));
                }
            } else {
                // Case-insensitive search
                foreach ($this->searchableColumns as $column) {
                    $builder->orWhere($column, 'like', "%{$search}%");
                }
            }
        });
    }
}
