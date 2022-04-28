<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DiaryItem extends Component
{

    public $day;
    public $month;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($day, $month)
    {
        $this->day = $day;
        $this->month = $month;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.diary-item');
    }
}
