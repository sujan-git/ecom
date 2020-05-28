<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Mail;
use App\Mail\ContactEmail;

class ContactController extends Controller
{
    //

    public function __construct(Contact $contact){
    	$this->contact = $contact;
    }
    public function sendMail(Request $request){
      
    	 $this->validate($request, [
	        'email' => 'required|email',
	        'message' => 'required'
        ]);

    	 try{
            Mail::to(env('ADMIN_EMAIL'))->send(new ContactEmail($request));
             \Session::flash('success','Thankyou for your contacting us.');
        }catch(Exception $e){
           \Session::flash('error', 'Sorry! Your feedback could not be sent at this moment.');
        }
        

        return redirect()->route('contact');
        
        
    }
}
