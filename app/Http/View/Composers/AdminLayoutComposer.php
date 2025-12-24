<?php

namespace App\Http\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class AdminLayoutComposer
{
    public function compose(View $view): void
    {
        $view->with('settings', Setting::first());
    }
}

