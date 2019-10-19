<?php

namespace App\Jobs\Eve;

use App\Jobs\Eve\Loaders\CharacterBasic;
use App\Models\Eve\Alliance;
use App\Models\Eve\Character;
use App\Models\Eve\Corporation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateEveCharactersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $chars = Character::pluck('id')
            ->merge(
                Corporation::pluck('ceo_id')
            )
            ->merge(
                Corporation::pluck('creator_id')
            )
            ->merge(
                Alliance::pluck('creator_id')
            )
            ->unique()
            ->all();

        foreach ($chars as $char) {
            dispatch(new CharacterBasic($char));
        }
    }
}
