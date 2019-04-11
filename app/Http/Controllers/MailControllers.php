<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class MailControllers extends Controller
{
  public function html_email(){
    $data = array('name'=>"Virat Gandhi");
    Mail::send('mail', $data, function($message) {
       $message->to('nurzaly@jtm.gov.my', 'Tutorials Point')->subject
          ('Laravel HTML Testing Mail');
       $message->from('xyz@gmail.com','Virat Gandhi');
    });
    echo "HTML Email Sent. Check your inbox.";
 }
}
