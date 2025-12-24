<?php

namespace App\Http\View\Composers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\View\View;

class FrontLayoutComposer
{
    public function compose(View $view): void
    {
        $view->with('settings', Setting::first());
        $view->with('categories', Category::orderBy('name')->get());
        $view->with('brands', Brand::orderBy('name')->get());
    }
}
