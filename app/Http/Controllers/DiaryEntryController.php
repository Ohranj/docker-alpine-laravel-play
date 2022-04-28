<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiaryEntryController extends Controller
{
    /**
     * Return the diary page view
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('diary', [
            'days' => date('t'),
            'month' => date('F'),
        ]);
    }
}
