<?php

namespace SLBR\Listeners;

use \Exception;

use Log;
use Mail;

use SLBR\Events\DefinitionApprovedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DefinitionApprovedEventListener
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
     * @param  DefinitionApprovedEvent  $event
     * @return void
     */
    public function handle(DefinitionApprovedEvent $event)
    {
        $definition = $event->definition;

        try 
        {
            Log::debug(sprintf('Sending expression approval e-mail to %s', $definition->email));
            Mail::send('emails.definitionApproved', array('contributor' => $definition->contributor, 'text' => $definition->expression()->first()->text), function($email) use($definition)
            {                    
                $email->from('no-reply@speaklikeabrazilian.com', 'Speak Like A Brazilian');   
                $email->to($definition->email, $definition->contributor);
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
