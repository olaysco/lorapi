<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait Filterable
{
    /**
     * Filters the collection based on the
     * sorting values in the param array
     *
     * @param  array $filteringCriteria
     * @param \Illuminate\Support\Collection $data
     *
     * @return \Illuminate\Support\Collection
     */
    public function filterBy(array $filteringCriteria, Collection $data)
    {
        foreach ($filteringCriteria as $criteria => $value) {
            $data = $data->filter(function ($character) use ($criteria, $value) {
                return property_exists($character, $criteria) ?
                    !strcasecmp($character->$criteria, $value) : true;
            });
        }
        return $data;
    }
}
