<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\ParseCharacterRequest;
use App\Jobs\Eve\Loaders\CharacterBasic;
use App\Services\CharactersNames;
use App\Http\Controllers\Controller;
use App\Services\FindCharacterByName;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function parseCharacters(
        ParseCharacterRequest $request,
        CharactersNames $charactersNames,
        FindCharacterByName $characterByName
    )
    {
        $names = $charactersNames->parse($request->getNames());

        foreach ($names as $name) {

            if ($charId = $characterByName->find($name)) {

                $this->dispatchNow(new CharacterBasic($charId));
            }
        }

        return back(Response::HTTP_CREATED)->with(['success' => 'Success']);
    }
}
