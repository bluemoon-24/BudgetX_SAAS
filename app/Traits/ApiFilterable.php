<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait ApiFilterable
{
    /**
     * Apply sorting, filtering, and searching to a query builder based on request parameters.
     *
     * @param  Builder  $query
     * @param  Request  $request
     * @param  array    $searchableColumns
     * @return Builder
     */
    protected function applyFilters(Builder $query, Request $request, array $searchableColumns = []): Builder
    {
        // 1. Filtering: ?filter[status]=active&filter[category_id]=5
        if ($request->has('filter') && is_array($request->input('filter'))) {
            foreach ($request->input('filter') as $field => $value) {
                // Basic implementation: ensure exact match. 
                // For advanced filters (like operators), you'd expand this.
                $query->where($field, $value);
            }
        }

        // 2. Searching: ?search=keyword
        if ($request->has('search') && !empty($searchableColumns)) {
            $searchTerm = $request->input('search');
            $query->where(function (Builder $q) use ($searchTerm, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    $q->orWhere($column, 'like', "%{$searchTerm}%");
                }
            });
        }

        // 3. Sorting: ?sort=-created_at,name
        if ($request->has('sort')) {
            $sorts = explode(',', $request->input('sort'));
            foreach ($sorts as $sortColumn) {
                $direction = 'asc';
                if (str_starts_with($sortColumn, '-')) {
                    $direction = 'desc';
                    $sortColumn = ltrim($sortColumn, '-');
                }
                $query->orderBy($sortColumn, $direction);
            }
        }

        return $query;
    }
}
