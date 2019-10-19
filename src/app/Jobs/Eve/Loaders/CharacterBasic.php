<?php

namespace App\Jobs\Eve\Loaders;

use App\Models\Eve\Character;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Swagger\Client\Api\CharacterApi;

class CharacterBasic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    protected $charId;

    /**
     * @var \Swagger\Client\Api\CharacterApi
     */
    protected $characterApi;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $charId)
    {
        $this->charId       = $charId;
        $this->characterApi = new CharacterApi;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $character = $this->characterApi->getCharactersCharacterId($this->charId);

        if (!$char = Character::find($this->charId)) {
            $char     = new Character;
            $char->id = $this->charId;
        }

        $char->corporation_id  = $character->getCorporationId();
        $char->alliance_id     = $character->getAllianceId();
        $char->name            = $character->getName();
        $char->birthday        = $character->getBirthday();
        $char->security_status = $character->getSecurityStatus();

        $char->save();
    }
}
