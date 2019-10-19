<?php

namespace App\Jobs\Eve;

use App\Jobs\Eve\Loaders\CorporationBasic;
use App\Models\Eve\Alliance;
use App\Models\Eve\Character;
use App\Models\Eve\Corporation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateEveCorporationsJob implements ShouldQueue
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
        $corps = Corporation::pluck('id')
            ->merge(
                Character::pluck('corporation_id')
            )
            ->merge(
                Alliance::pluck('creator_corporation_id')
            )
            ->merge(
                Alliance::pluck('executor_corporation_id')
            )
            ->unique()
            ->all();

        foreach ($corps as $corp) {
            dispatch(new CorporationBasic($corp));
        }
    }
}
