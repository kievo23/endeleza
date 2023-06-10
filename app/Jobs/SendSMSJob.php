<?php

namespace App\Jobs;

use App\Outbox;
use App\SMS;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone,$sms;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone,$sms)
    {
        $this->phone = $phone;
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Sending SMS the right way like a pro with queues and jobs
        $rst = SMS::sendSmsLeopard($this->phone,$this->sms);
        Outbox::log(json_decode($rst),$this->sms);
    }
}
