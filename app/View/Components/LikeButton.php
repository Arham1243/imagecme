<?php

namespace App\View\Components;

use App\Models\DiagnosticCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class LikeButton extends Component
{
    public $case;

    public $liked;

    public $likesCount;

    public $class;

    public $showCount;

    public $label;

    public function __construct($caseId, $class, $showCount = false, $label = null)
    {
        $this->case = DiagnosticCase::find($caseId);
        $this->likesCount = $this->case->likes()->count();
        $this->liked = $this->case->likes()->where('user_id', Auth::id())->exists();
        $this->class = $class;
        $this->showCount = $showCount;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.like-button');
    }
}
