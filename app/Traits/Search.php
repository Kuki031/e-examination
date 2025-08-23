<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Query\Builder;

trait Search
{
    public function searchAny(string $model, array $searchColumns)
    {
        $searchTerm = request('search');

        if (!$searchTerm) {
            return $model::query();
        }

        return $model::where(function ($query) use ($searchColumns, $searchTerm) {
            foreach ($searchColumns as $column) {
                $query->orWhere($column, 'LIKE', '%' . $searchTerm . '%');
            }
        });
    }
}
