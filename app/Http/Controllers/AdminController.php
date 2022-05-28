<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Add user upload data to queue
     * @param \Illuminate\Http\Request $request
     * @return string JSON response
     */
    public function upload_users(Request $request)
    {
        $file = $request->file('user_upload_file');
        $fileName = $file->getClientOriginalName();


        return response()->json([
            'success' => true,
            'message' => 'Users added to queue',
            'file' => $request->file('user_upload_file')->getClientOriginalName()
        ]);
    }


    /**
     * Return the admin home page view
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index');
    }
}
