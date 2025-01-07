<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CaseCard extends Component
{
    public $case;

    public function __construct($case)
    {
        $this->case = $case;
    }

    public function render(): View|Closure|string
    {
        return view('components.case-card');
    }
}