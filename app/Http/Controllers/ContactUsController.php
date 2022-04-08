<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
            'phone' => ['required'],
            'message' => ['required']
        ]);

        //Encrypt the message before saving to DB; https://laravel.com/docs/9.x/encryption
        //Populate the created at field as well
        DB::table('contact_us')->insert([
            'firstname' => $request->name,
            'lastname' => $request->surname,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Contact Us data valid',
        ]);
    }
}
