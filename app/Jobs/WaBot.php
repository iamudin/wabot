<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class WaBot implements ShouldQueue
{
    use Queueable;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->sendMessage();
        
    }

    function sendMessage(){
        $response = Http::post(config('wabot.wa_host') . '/message/send-text', [
            'session' => 'sadhan',
            'to' => $this->data['to'],
            'text' => $this->data['text'],
            'is_group' => false,
        ]);
    }
    
}
