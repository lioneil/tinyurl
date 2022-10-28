<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    /**
     * Unsearchable columns.
     *
     * @var array
     */
    public $unsearchableColumns = ['id', 'updated_at', 'created_at', 'deleted_at'];

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
     * @param  string  $relatedTable
     * @param  array  $relatedTableColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function scopeSearch (Builder $query, $search, $relatedTable = null, $relatedTableColumns = [])
    {
        if (empty($search)) {
            return $query;
        }

        if (empty($relatedTable)) {
            return $query->where(function ($builder) use ($search) {
                $this->performSearch($builder, $search);
            });
        }

        return $query->whereHas($relatedTable, function ($builder) use ($search, $relatedTableColumns) {
            $this->performSearch($builder, $search, $relatedTableColumns, $strict = true);
        });
    }

    /**
     * Scope a query to search through columns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @param  string  $relatedTable
     * @param  array  $relatedTableColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function scopeOrSearch (Builder $query, $search, $relatedTable = null, $relatedTableColumns = [])
    {
        if (empty($search)) {
            return $query;
        }

        if (empty($relatedTable)) {
            return $query->orWhere(function ($builder) use ($search) {
                $this->performSearch($builder, $search);
            });
        }

        return $query->orWhereHas($relatedTable, function ($builder) use ($search, $relatedTableColumns) {
            $this->performSearch($builder, $search, $relatedTableColumns, $strict = true);
        });
    }

    /**
     * Perform case-sensitive or insensitive search.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $search
     * @param array $columns
     * @return void
     */
    function performSearch (Builder $builder, $search, $columns = [], $strict = false)
    {
        $columns = empty($columns) ? $this->searchableColumns : $columns;

        if (str_contains($search, '"')) {
            // Case-sensitive search
            foreach ($columns as $column) {
                $builder->orWhere($column, trim($search, '"'));
            }
        } else {
            // Case-insensitive search
            foreach ($columns as $column) {
                if ($strict) {
                    $builder->where($column, 'like', "%{$search}%");
                } else {
                    $builder->orWhere($column, 'like', "%{$search}%");
                }
            }
        }
    }
}
