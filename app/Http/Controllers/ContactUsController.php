<?php

namespace App\Http\Controllers;

use App\Events\ContactUsEmailSent;
use App\Jobs\ContactUsClientMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class ContactUsController extends Controller
{
    /**
     * Store a new Contact Us row in the database. Client email response is issued via job. Event is also triggered to update the DB row to confirm an email has been sent to the client.
     * @param  \Illuminate\Http\Request  $request
     * @return string JSONString containg result of insert success
     */
    public static function storeContactUsForm(Request $request)
    {
        $request->validateWithBag('contactUs', [
            'name' => ['required'],
            'surname' => ['required'],
            'email' => ['required', 'email:rfc,dns'],
            'message' => ['required']
        ]);

        $insertID = DB::table('contact_us')->insertGetId([
            'firstname' => $request->name,
            'lastname' => $request->surname,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => Crypt::encryptString($request->message),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Log::info("Contact us form saved. ID = {$insertID}");

        $details = [
            'title' => 'Thank you for contacting us',
            'firstname' => $request->name,
            'message' => $request->message,
            'ID' => $insertID
        ];

        dispatch(new ContactUsClientMail($details, $request->email));

        event(new ContactUsEmailSent([
            'rowID' => $insertID,
            'receiver' => $request->email
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Contact Us form received',
        ]);
    }
}
