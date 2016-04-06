<?php

namespace SLBR\Listeners;

use \Exception;

use Log;
use Mail;

use SLBR\Events\MediaApprovedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MediaApprovedEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MediaApprovedEvent  $event
     * @return void
     */
    public function handle(MediaApprovedEvent $event)
    {
        $text = $event->text;
        $to = $event->email;
        $contributor = $event->contributor;

        try 
        {
            Log::debug(sprintf('Sending media approval e-mail to %s', $to));
            Mail::send('emails.mediaApproved', array('contributor' => $contributor, 'text' => $text), function($email) use($to, $contributor)
            {                    
                $email->from('no-reply@speaklikeabrazilian.com', 'Speak Like A Brazilian');   
                $email->to($to, $contributor);
                $email->subject('Your expression was published in Speak Like A Brazilian');
            });
        }
        catch (Exception $e)
        {
            Log::warning("Error sending approval e-mail: " . $e->getMessage());
            Log::error($e);
        }
    }
}
