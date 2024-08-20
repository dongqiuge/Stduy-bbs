<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * 首页
     *
     * @return Factory|View|Application
     */
    public function root(): Factory|View|Application
    {
        return view('pages.root');
    }
}
