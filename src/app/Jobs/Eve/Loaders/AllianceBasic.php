<?php

namespace App\Jobs\Eve\Loaders;

use App\Models\Eve\Alliance;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Swagger\Client\Api\AllianceApi;

class AllianceBasic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    protected $alliId;

    /**
     * @var AllianceApi
     */
    protected $allianceApi;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $alliId)
    {
        $this->alliId      = $alliId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->allianceApi = new AllianceApi();

        $allianceData = $this->allianceApi->getAlliancesAllianceId($this->alliId);

        if (!$alliance = Alliance::find($this->alliId)) {
            $alliance     = new Alliance;
            $alliance->id = $this->alliId;
        }

        $alliance->name                    = $allianceData->getName();
        $alliance->ticker                  = $allianceData->getTicker();
        $alliance->creator_corporation_id  = $allianceData->getCreatorCorporationId();
        $alliance->creator_id              = $allianceData->getCreatorId();
        $alliance->executor_corporation_id = $allianceData->getExecutorCorporationId();

        $alliance->save();
    }
}
