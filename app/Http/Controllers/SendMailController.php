<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendMailController extends Controller
{
    public function send_mail(Request $request)
    {
    	$details = [
    		'subject' => 'Test Notification'
    	];

        $job = (new \App\Jobs\SendQueueEmail($details))
            	->delay(now()->addSeconds(60));
                dispatch($job);
        echo "Mail send successfully !!";
    }
}
