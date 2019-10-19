<?php

namespace App\Jobs\Eve;

use App\Jobs\Eve\Loaders\AllianceBasic;
use App\Models\Eve\Alliance;
use App\Models\Eve\Character;
use App\Models\Eve\Corporation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateEveAlliancesJob implements ShouldQueue
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
        $alliances = Alliance::pluck('id')
            ->merge(
                Character::pluck('alliance_id')
            )
            ->merge(
                Corporation::pluck('alliance_id')
            )
            ->unique()
            ->all();

        foreach ($alliances as $alliance) {
            dispatch(new AllianceBasic($alliance));
        }
    }
}
