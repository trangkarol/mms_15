<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReminderEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $data ;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
         $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->view('common.send_mail')->with($this->data);
    }
}
