<?php

namespace App\Jobs\Eve\Loaders;

use App\Models\Eve\Corporation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Swagger\Client\Api\CorporationApi;

class CorporationBasic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    protected $corpId;

    /**
     * @var CorporationApi
     */
    protected $corporationApi;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $corpId)
    {
        $this->corpId         = $corpId;
        $this->corporationApi = new CorporationApi();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $corporation = $this->corporationApi->getCorporationsCorporationId($this->corpId);

        if (!$corp = Corporation::find($this->corpId)) {
            $corp     = new Corporation;
            $corp->id = $this->corpId;
        }

        $corp->alliance_id = $corporation->getAllianceId();
        $corp->name        = $corporation->getName();
        $corp->ticker      = $corporation->getTicker();
        $corp->ceo_id      = $corporation->getCeoId();
        $corp->creator_id  = $corporation->getCreatorId();

        $corp->save();
    }
}
