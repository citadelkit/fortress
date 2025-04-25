<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Citadel\Components\Page;
use Citadel\Components\Layout\CustomView;

class CitadelController extends Controller
{
    public function index()
    {
        return Page::make('Test Page')
            ->sidebar(view('menu.admin'))
            ->schema([
                CustomView::make('main')->view('welcome')
            ])
            ->render();
    }
}
