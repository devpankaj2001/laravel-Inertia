<?php

namespace App\Jobs;

use App\Models\Inquiry;
use App\Services\LeadScoringService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScoreLeadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $inquiryId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $inquiryId)
    {
        $this->inquiryId = $inquiryId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $inquiry = Inquiry::find($this->inquiryId);

        if (!$inquiry) {
            return;
        }

        try {
            LeadScoringService::scoreInquiry($inquiry);
        } catch (\Throwable $e) {
            Log::error("ScoreLeadJob error on inquiry #{$this->inquiryId}: " . $e->getMessage());
        }
    }
}
