<?php

namespace App\Http\Controllers;

use App\Jobs\ContactUsClientMail;
use App\Mail\ContactUsClientConfirm;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    /**
     * Store a new Contact Us row in the database
     * @return string JSONString containg result of insert success
     */
    public static function storeContactUsForm(Request $request): mixed
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

        //Disptach new job to send email;
        dispatch(new ContactUsClientMail($details, $request->email));

        return response()->json([
            'success' => true,
            'message' => 'Contact Us form received',
        ]);
    }
}
