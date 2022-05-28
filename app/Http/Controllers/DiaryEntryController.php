<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiaryEntryController extends Controller
{
    /**
     * Return the diary page view. Returns the number of days in current month, the string type of the month, the input elem month type string and the current day of the month if view matches current month in time
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $dateObj = now();
        $currentMonthDay = $dateObj->format('d');

        if (count($request->query)) $dateObj = $request->query()['date'];

        $dateTimeObj = Carbon::parse($dateObj);

        if ($dateTimeObj->format('Y-m') != Carbon::parse(now())->format('Y-m')) $currentMonthDay = NULL;

        return view('diary', [
            'days' => cal_days_in_month(CAL_GREGORIAN, $dateTimeObj->format('m'), $dateTimeObj->format('Y')),
            'month' => $dateTimeObj->format('M'),
            'inputValue' => Carbon::parse($dateObj)->format('Y-m'),
            'currentMonthDay' => $currentMonthDay
        ]);
    }
}
