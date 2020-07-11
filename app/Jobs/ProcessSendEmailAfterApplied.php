<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendAppliedUser;


class ProcessSendEmailAfterApplied implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user_email;
    private $user_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_email , $user_name)
    {
        $this->user_email = $user_email;
        $this->user_name = $user_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $to = $this->user_email;
        try{
            \Mail::to($to)->send( new SendAppliedUser($this->user_name));
        }catch(\Exception $e){
            \Log::Info($e->getMessage());
        }
    }
}
