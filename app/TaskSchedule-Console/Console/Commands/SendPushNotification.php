<?php

namespace App\Console\Commands;

use App\Models\PushNotification\PushNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendPushNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending not sent push notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //get all not sent notifications before or equal current time
        $notifications = PushNotification::where('is_sent', 0)
                                        ->where('send_date', '<=', Carbon::now())
                                        ->get();

        foreach ($notifications as $notification) {
            //send notification via firebase

            // update notification
            $notification->update([
                'is_sent' => 1,
            ]);
        }
    }
}
