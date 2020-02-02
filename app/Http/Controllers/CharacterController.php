<?php

namespace App\Http\Controllers;

use App\Traits\Filterable;
use App\Traits\Pagnitable;
use App\Traits\Sortable;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CharacterController extends Controller
{
    use Pagnitable;
    use Sortable;
    use Filterable;

    public $movieClient;
    static $sortKeys = ["asc" => true, "desc" => true];

    /**
     * Fetches all characters from api
     *
     */
    public function characters()
    {
        $this->movieClient = new Client(['base_uri' => 'https://the-one-api.herokuapp.com']);
        $result = $this->movieClient->get('v1/character', [
            'headers' =>
            [
                'Authorization' => "Bearer " . config('app.lors_key')
            ]
        ]);
        $allCharacters = json_decode($result->getBody()->getContents());
        return $allCharacters;
    }

    /**
     * Return characters based on user criteria
     * specified in the param body
     *
     * @param Illuminate\Http\Request $request
     */
    public function all(Request $request)
    {
        $race = $request->race;
        $gender = $request->gender;
        $raceOrder = $request->raceOrder;
        $genderOrder = $request->genderOrder;
        $charactersCollection = collect($this->characters()->docs);
        $filtered = $this->filterBy($this->buildFilteringCriteria($race, $gender), $charactersCollection);
        $sorted = $this->sortBy($this->buildSortingCriteria($raceOrder, $genderOrder), $filtered);
        $result = $request->pageSize ?
            $this->paginate($sorted, $sorted->count(), $request->pageSize) :
            $sorted;
        return response()->json($result, 200);
    }

    /**
     * builds an array of criteria
     * by checking if they're present
     *
     * @param  string race
     * @param string gender
     *
     * @return array
     */
    public function buildFilteringCriteria($race = "", $gender = "")
    {
        $filteringCriteria = [];

        if (!empty($race)) {
            $filteringCriteria["race"] = $race;
        }
        if (!empty($gender)) {
            $filteringCriteria["gender"] = $gender;
        }

        return $filteringCriteria;
    }

    /**
     * Checks if a predefined filtering
     * criteria is present and uses it to
     * build an array of criteria
     *
     * @param  string race
     * @param string gender
     *
     * @return array
     */
    public function buildSortingCriteria($raceOrder = "", $genderOrder = "")
    {
        $sortingCriteria = [];

        if (!empty($raceOrder) && Arr::has(self::$sortKeys, $raceOrder)) {
            $sortingCriteria["race"] = $raceOrder;
        }
        if (!empty($runtime) && Arr::has(self::$sortKeys, $genderOrder)) {
            $sortingCriteria["gender"] = $genderOrder;
        }

        return $sortingCriteria;
    }
}
