<?php

namespace App\Http\Controllers;

use App\Mail\OrderCreated;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        return view('email_index')->with('pageTitle', 'E-Mail');
    }

    public function send_email_with_notification1()
    {
        $invoice = null;
        $user = User::findOrFail(2);
        $user->notify(new InvoicePaid($invoice));
        return redirect()->route('email.home')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'E-Mail sent with success (using Notifications)');
    }


}