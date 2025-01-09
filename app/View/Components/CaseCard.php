<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CaseCard extends Component
{
    public $case;

    public $send_popup_theme;

    public function __construct($case, $send_popup_theme = 'light')
    {
        $this->case = $case;
        $this->send_popup_theme = $send_popup_theme;
    }

    public function render(): View|Closure|string
    {
        return view('components.case-card');
    }
}
