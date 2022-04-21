<?php

namespace App\View\Components;

use Illuminate\View\Component;

class userCard extends Component
{
    /**
     * Holds the user data
     * @var object
     */
    public $cardUser;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($cardUser)
    {
        $this->cardUser = $cardUser;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.userCard');
    }
}
