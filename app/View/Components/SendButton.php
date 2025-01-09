<?php

namespace App\View\Components;

use App\Models\DiagnosticCase;
use Illuminate\View\Component;

class SendButton extends Component
{
    public $case;

    public $class;

    public $label;

    public $theme;

    public $showText;

    public function __construct($caseId, $class, $showText = false, $label = null, $theme = 'dark')
    {
        $this->case = DiagnosticCase::find($caseId);
        $this->class = $class;
        $this->label = $label;
        $this->theme = $theme;
        $this->showText = $showText;
    }

    public function render()
    {
        return view('components.send-button');
    }
}
