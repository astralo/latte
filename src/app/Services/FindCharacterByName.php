<?php


namespace App\Services;


use App\Exceptions\Eve\CharacterNotFoundException;
use Swagger\Client\Api\SearchApi;

class FindCharacterByName
{
    protected $search;

    protected $categories = [
        'character'
    ];

    public function __construct()
    {
        $this->search = new SearchApi();
    }

    /**
     * @param string $name
     *
     * @return int|null
     */
    function find(string $name): ?int
    {
        try {
            $result = $this->search->getSearch($this->categories, $name, null, null, null, null, true);

            $charIds = $result->getCharacter();

            if (!$result->valid() && empty($charIds[0])) {
                throw new CharacterNotFoundException;
            }

            return $charIds[0];

        } catch (\Exception $exception) {
            return null;
        }
    }
}
