<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Return the admin home page view
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index');
    }
}
