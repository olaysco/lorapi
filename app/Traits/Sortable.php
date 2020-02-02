<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait Sortable
{
    /**
     * Sorts the collection based on the
     * sorting values in the param array
     *
     * @param  array $filteringCriteria
     * @param \Illuminate\Support\Collection $data
     *
     * @return \Illuminate\Support\Collection
     */
    public function sortBy(array $sortingCriteria, Collection $data)
    {
        foreach ($sortingCriteria as $criteria => $order) {
            if ($order === 'asc') {
                $data = $data->sortBy($criteria);
            } else {
                $data = $data->sortByDesc($criteria);
            }
        }

        return $data;
    }
}
