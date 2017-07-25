<?php

namespace Thorazine\Hack\Tests\Feature;

use Tests\TestCase;
use Exception;
use Mail;

class MailTest extends TestCase
{
    /** 
     * @test
     */
    public function mail_send_test() 
    {
        try {
        	// email user for verification to confirm the location
            Mail::send('hack::emails.test', [], function($message) {
                $message->to('test@test.nl');
                $message->subject('Hack CMS - Test mail');
            });

            $this->assertTrue(true);
        } 
        catch (Exception $e) {
        	$this->assertTrue(false, 'Mail failed with the following response: '.$e->getMessage());
        }
    }
}